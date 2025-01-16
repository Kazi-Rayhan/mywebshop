<?php

namespace App\Http\Controllers\Dashboard\Enterprise;


use App\Http\Controllers\Controller;
use App\Mail\ElavonPaymentDetails;
use App\Mail\ExternalWelcomeEmail;
use App\Mail\NotificationEmail;
use App\Mail\paymentCapture;
use App\Mail\PaymentMethodAccessMail;
use App\Mail\WelcomeEmail;
use App\Models\Charge;
use App\Models\EnterpriseOnboarding;
use App\Models\PaymentMethodAccess;
use App\Models\ProtectedLink;
use App\Models\Subscription;
use App\Models\SubscriptionCharge;
use App\Models\User;
use App\Payment\Subscribe;
use Barryvdh\DomPDF\Facade\Pdf;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use TCG\Voyager\Models\Role;
use Iziibuy;

class DashboardController extends Controller
{



    public function startSubscription(Subscription $subscription)
    {
        if ($subscription->subscribable->user_id != auth()->id())
            return abort(403);
        try {

            DB::beginTransaction();
            $subscription_fee = $subscription->fee;
            $subscribe = (new Subscribe())->subscription();

            $subscribe = $subscribe->getUrl($subscription_fee, false, [
                'continueurl' => route('enterprise.subscription.success', $subscribe->subscription->id),
                'cancelurl' => route('enterprise.subscription.cancel', $subscribe->subscription->id)
            ]);

            $subscription->update([
                'key' => $subscribe['data']['payment_id'],
                'url' => $subscribe['data']['url'],
            ]);
            DB::commit();
            return redirect($subscription->url);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
    public function subscriptionSuccess($subscription = null)
    {



        try {
            DB::beginTransaction();
            $subscriptionDatabase = Subscription::where('key', $subscription)->first();
            $subscriptionQuickpay = (new Subscribe())->subscription($subscription);

            if ($subscriptionQuickpay->subscription->state == "active") {

                $create_charge = $subscriptionQuickpay->charge($subscriptionDatabase->fee);

                if ($create_charge['status']) {
                    $payment = $subscriptionQuickpay->payment($create_charge['data']->id);
                    if ($payment['data']->state == 'processed') {

                        $subscriptionDatabase->paid_at = now();
                        $subscriptionDatabase->status = true;
                        $subscriptionDatabase->establishment_status = true;
                        $subscriptionDatabase->save();

                        $subscriptionDatabase->charges()->create([
                            'amount' => $subscriptionDatabase->fee,
                            'status' => true
                        ]);

                        $enterpriseOnboarding = $subscriptionDatabase->subscribable;
                        $enterpriseOnboarding->status = true;
                        $enterpriseOnboarding->key = Str::uuid();
                        $enterpriseOnboarding->last_paid_at = now();
                        $enterpriseOnboarding->save();
                    }
                }
            };
            DB::commit();
            Mail::to($enterpriseOnboarding->user->email)->send(new PaymentMethodAccessMail($enterpriseOnboarding));
            Mail::to(setting('site.email'))->send(new PaymentMethodAccessMail($enterpriseOnboarding));

            return redirect()->route('enterprise.contract')->with('success', 'Subscription completed');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('enterprise.contract')->withErrors($e->getMessage());
        } catch (Error $e) {
            DB::rollBack();
            return redirect()->route('enterprise.contract')->withErrors($e->getMessage());
        }
    }

    public function dashboard()
    {
        $paymentMethodAccesses = PaymentMethodAccess::where('user_id', auth()->id())->get();
        return view('dashboard.enterprise.index', compact('paymentMethodAccesses'));
    }
    public function edit()
    {

        $enterprise = auth()->user()->enterpriseOnboarding;
        return view('dashboard.enterprise.edit', compact('enterprise'));
    }
    public function update(Request $request)
    {

        $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'company_email' => ['required', 'string', 'max:255'],
            'company_address.city' => ['required', 'string', 'max:255'],
            'company_address.street' => ['required', 'string', 'max:255'],
            'company_address.zip' => ['required', 'string', 'max:255'],
            'company_registration' => ['required', 'string', 'max:255'],
            'company_domain' => ['required', 'url', 'max:255'],
        ]);
        $enterprise = auth()->user()->enterpriseOnboarding;

        $enterprise->update([
            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
            'company_address' => $request->company_address,
            'company_domain' => $request->company_domain,
            'company_registration' => $request->company_registration,
        ]);

        return redirect()->back()->with('success', 'Enterprise info updated successfully');
    }

    public function enterprise()
    {


        $enterprise = auth()->user()->enterpriseOnboarding;

        if ($enterprise && $enterprise->last_paid_at == null) {
            return redirect(auth()->user()->enterpriseOnboarding->subscription->url);
        }
        if ($enterprise->user_id != auth()->id()) abort(403);
        $subscription = $enterprise->subscription->key;
        $subscriptionQuickpay = (new Subscribe())->subscription($subscription)->subscription;


        return view('dashboard.enterprise.index', compact('enterprise', 'subscriptionQuickpay'));
    }


    public function charges()
    {

        $paymentMethodAccess = auth()->user()->enterpriseOnboarding;
        if ($paymentMethodAccess->user_id != auth()->id())
            abort(403);
        $charges = $paymentMethodAccess->subscription->charges()->latest()->paginate(10);

        return view('dashboard.enterprise.charges', compact('paymentMethodAccess', 'charges'));
    }

    public function contract()
    {

        $enterprise = auth()->user()->enterpriseOnboarding;
        if ($enterprise->user_id != auth()->id())
            abort(403);

        return view('dashboard.enterprise.contract', compact('enterprise'));
    }

    public function cancelSubscription(Subscription $subscription)
    {
        if ($subscription->subscribable->user_id != auth()->id())
            return abort(403);
        $quickPay = new Subscribe();
        $response = $quickPay->stopsubscription($subscription);
        return redirect()->back()->with('success', "Subscription cancelled for this account");
    }

    public function downloadInvoice(SubscriptionCharge $charge)
    {

        $reg_tax = setting('payment.registration_tax');
        $amount = $charge->amount;
        $base_price = ($amount * 100) / (100 + $reg_tax);
        $tax = $amount - $base_price;
        $pdf = Pdf::loadView('dashboard.enterprise.pdf.invoice', ['charge' => $charge, 'tax' => $tax, 'base_price' => $base_price]);
        $fileName = 'invoice/invoice' . uniqid() . '.pdf';
        try {
            return $pdf->download($fileName);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function signContract(Request $request, EnterpriseOnboarding $enterpriseOnboarding)
    {


        $message = 'Company Name: ' . $enterpriseOnboarding->company_name . '<br> ' .
            'Org number: ' . $enterpriseOnboarding->company_registration . '<br>' .
            'Company email: ' . $enterpriseOnboarding->company_email . '<br>' .
            'Contact person: ' . $enterpriseOnboarding->user->name . ' ' . $enterpriseOnboarding->user->last_name . ' <br>' .
            'Phone: ' . $enterpriseOnboarding->user->phone . '<br>
        <b> Selected payment Methods</b> <br>' . $request->visa .
            ' <br>' . $request->mastercard . '<br> ' . $request->vipps . '<br> ' . $request->google_pay . '<br> ' . $request->apple_pay;
        $mail_data = [
            'subject' => $enterpriseOnboarding->company_name . ' has submited payment methods',
            'body' => $message,
            'button_link' => $enterpriseOnboarding->company_domain,
            'button_text' => 'View Shop',
            'emails' => [],
        ];

        $enterpriseOnboarding->update([
            'paymentMethod' => $request->filled('vipps')   ? 'quickpay' : 'elavon',
            'contract_signed' => 1
        ]);

        Mail::to(setting('site.email'))->send(new NotificationEmail($mail_data));
        if ($request->filled('B2B')) {
            return redirect()->route('shop.setup_payment_two');
        }
        if ($enterpriseOnboarding->paymentMethod == 'quickpay') {
            $response = Http::post(
                'https://hooks.zapier.com/hooks/catch/2912165/38jaejy',
                [
                    'shop_id' => $enterpriseOnboarding->key,
                    'first_name' => $enterpriseOnboarding->user->name,
                    'last_name' => $enterpriseOnboarding->user->last_name,
                    'shop_name' => $enterpriseOnboarding->company_name,
                    'title' => $enterpriseOnboarding->title,
                    'company_name' => $enterpriseOnboarding->company_name,
                    'company_url' => $enterpriseOnboarding->company_domain,
                    'company_registration' => $enterpriseOnboarding->company_registration,
                    'email' => $enterpriseOnboarding->company_email,
                    'phone' => $enterpriseOnboarding->user->phone,
                    'city' => $enterpriseOnboarding->company_address->city,
                    'street' => $enterpriseOnboarding->company_address->street,
                    'post_code' => $enterpriseOnboarding->company_address->zip,
                    'visa' => $request->visa ? true : false,
                    'mastercard' => $request->mastercard ? true : false,
                    'amex' => $request->amex ? true : false,
                    'vipps' => $request->vipps ? true : false,
                    'google_pay' => $request->google_pay ? true : false,
                    'apple_pay' => $request->apple_pay ? true : false
                ]
            );
            Log::info($response->json());
        } else {
            return redirect()->route('enterprise.setup_elavon_payment');
        }


        return back();
    }
    public function settings()
    {

        return view('dashboard.enterprise.settings');
    }
    public function passwordUpdate(Request $request)
    {
        // Validate the form data
        $request->validate([
            'old_pass' => 'required',
            'new_pass' => 'required|min:8',
        ]);
        $user = Auth::user();
        if (!Hash::check($request->old_pass, $user->password)) {
            return redirect()->route('enterprise.settings')->withErrors('The old password is incorrect.');
        }

        // Hash and update the new password
        $user->password = Hash::make($request->new_pass);
        $user->save();

        return redirect()->route('enterprise.dashboard')->with('success', 'Password changed successfully.');
    }
    public function settingsUpdate(Request $request)
    {


        $request->validate([
            'name' => 'required',
            'last_name' => 'required',

        ]);
        Auth()->user()->update([
            'name' => $request->name,
            'last_name' => $request->last_name,

        ]);
        return redirect()->back()->with('success', 'settings update successfully.');
    }
    public function completeProfile()
    {
        return view('dashboard.enterprise.complete');
    }
    public function completeProfileStore(Request $request)
    {
        $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'company_email' => ['required', 'string', 'max:255'],
            'company_address.city' => ['required', 'string', 'max:255'],
            'company_address.street' => ['required', 'string', 'max:255'],
            'company_address.zip' => ['required', 'string', 'max:255'],
            'company_registration' => ['required', 'string', 'max:255'],
            'company_domain' => ['required', 'url', 'max:255'],
        ]);

        auth()->user()->enterpriseOnboarding->update([
            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
            'company_address' => $request->company_address,
            'company_domain' => $request->company_domain,
            'company_registration' => $request->company_registration,
        ]);

        $enterprise = auth()->user()->enterpriseOnboarding;

        $subscription_fee = $enterprise->getSubscriptionFee();
        $subscribe = (new Subscribe())->subscription();

        $subscribe = $subscribe->getUrl($subscription_fee, false, [
            'continueurl' => route('enterprise.subscription.success', $subscribe->subscription->id),
            'cancelurl' => route('enterprise.subscription.cancel', $subscribe->subscription->id)
        ]);

        $subscription = $enterprise->subscription()->create([
            'key' => $subscribe['data']['payment_id'],
            'url' => $subscribe['data']['url'],
            'fee' => $subscription_fee
        ]);

        return redirect($subscription->url);
    }



    public function setup_elavon_payment()
    {

        $enterprise = auth()->user()->enterpriseOnboarding;

        if ($enterprise->paymentMethod == 'elavon' && $enterprise->elavon_payment_setup == true || $enterprise->elavon_details_verified_by_shop == true) return redirect()->route('shop.dashboard');
        return view('dashboard.enterprise.payments.elavon_setup', compact('enterprise'));
    }

    public function store_setup_elavon_payment(Request $request)
    {
        $enterprise = auth()->user()->enterpriseOnboarding;


        if ($enterprise->paymentMethod == 'elavon' && $enterprise->elavon_payment_setup == true || $enterprise->elavon_details_verified_by_shop == true) return redirect()->route('shop.dashboard');

        // $request->validate([
        // 'meta.name' => 'required',
        // 'meta.businessAddress' => 'required',
        // 'meta.contact_phone' => 'required',
        // 'meta.contactPerson' => 'required',
        // 'meta.contact_email' => 'required',
        // 'meta.company_name' => 'required',
        // 'meta.comapny_address' => 'required',
        // 'meta.ownership' => 'required',
        // 'meta.orgNumber' => 'required',
        // 'meta.foundationDate' => 'required',
        // 'meta.businessDescription' => 'required',
        // 'meta.annualRevenue' => 'required',
        // 'meta.creditCardTurnover' => 'required',
        // 'meta.avgTransactionValue' => 'required',
        // 'meta.cardHolderPresent' => 'required',
        // 'meta.mailPhoneOrder' => 'required',
        // 'meta.internet' => 'required',
        // 'meta.gender' => 'required',
        // 'meta.dob' => 'required',
        // 'meta.share' => 'required',
        // 'meta.ceo' => 'required',
        // 'meta.privateAddress' => 'required',
        // 'meta.otherNationality' => 'required',
        // 'meta.country' => 'required',
        // 'meta.privatePhoneNumber' => 'required',
        // 'meta.mobileNumber' => 'required',
        // 'meta.privateEmail' => 'required',
        // 'meta.idNumber' => 'required',
        // 'meta.issueDate' => 'required',
        // 'meta.expiryDate' => 'required',
        // 'meta.nationality' => 'required',
        // 'meta.bankName' => 'required',
        // 'meta.accountHolderName' => 'required',
        // 'meta.accountNumber' => 'required',
        // 'meta.selectedUserName' => 'required',
        // 'meta.preferredUsername' => 'required',
        // 'meta.userEmail' => 'required',
        // 'meta.userPhoneNumber' => 'required',
        // 'meta.fullNameTitle' => 'required',
        // 'meta.date' => 'required',


        // ]);


        $imageData = $request->input('signature');
        $imageData = substr($imageData, strpos($imageData, ',') + 1);
        $imageData = base64_decode($imageData);
        $filename = 'signature/signature_' . uniqid() . '.png';

        Storage::disk('s3')->put($filename, $imageData);
        $meta = $request->meta;
        $meta['customer_profile'] = json_encode($meta['customer_profile']);
        $meta['authrized'] = json_encode($meta['authrized']);
        $meta['financial'] = json_encode($meta['financial']);
        $meta['report'] = json_encode($meta['report']);
        $meta['customerDetails'] = json_encode($meta['customerDetails']);
        $meta['trading'] = json_encode($meta['trading']);
        $meta['partner'] = json_encode($meta['partner']);
        $meta['productId'] = json_encode($meta['productId']);

        $meta['signature'] = $filename;
        $meta['ip_address'] = $request->ip();
        $meta['date'] = now();
        $enterprise->createMetas($meta);

        $protectedLink = ProtectedLink::updateOrCreate(['link' => route('view_payment_data', ['id' => $enterprise->id, 'type' => 'enterprise'])], [
            'link' => route('view_payment_data', ['id' => $enterprise->id, 'type' => 'enterprise']),
            'uid' => uniqid(),
            'password' => uniqid()
        ]);

        $enterprise->createMeta('elavon_details_verified_by_shop', false);

        $viewLink = route('view_payment_data', ['id' => $enterprise->id, 'type' => 'enterprise', 'uid' => $protectedLink->uid, 'password' => $protectedLink->password]);

        $contactMail = $request->meta['contact_email'];

        Mail::to($contactMail)->send(new paymentCapture($enterprise, $viewLink));
        // try {
        //     // Pass the link to the Mailable
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Failed to send email.']);
        // }
        return redirect()->route('enterprise.dashboard')->with('success', 'Your details have been successfully submitted. Please check your email for confirmation . Thank you .');
    }
    public function viewPaymentData($id)
    {
        $external = PaymentMethodAccess::fid($id);


        // $external = auth()->user()->shop;
        if ($external->elavon_details_verified_by_shop != true) {
            return view('dashboard.enterprise.payments.confrimPaymentCapture', ['shop' => $external]);
        } else {
            return redirect()->route('enterprise.dashboard')->withErrors('You already verified your information');
        }
    }

    public function verifyElavonPayment(Request $request)
    {


        $enterprise = auth()->user()->enterpriseOnboarding;
        $shop = $enterprise;
        if ($enterprise->elavon_details_verified_by_shop != true) {
            $pdf = Pdf::loadview('pdf.elavon_payment_shop_details', compact('shop'));
            Mail::to('digitalisertweb@gmail.com')->bcc('didrik.tonnessen@elavon.com')->cc($enterprise->contact_email)->send(new ElavonPaymentDetails($enterprise, $pdf));
            $enterprise->createMeta('elavon_details_verified_by_shop', true);
            $enterprise->createMeta('needKYC', true);
            return redirect()->route('enterprise.dashboard');
        } else {
            return redirect()->route('enterprise.dashboard')->withErrors('You already verified your information');
        }
    }
}
