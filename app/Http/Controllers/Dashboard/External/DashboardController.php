<?php

namespace App\Http\Controllers\Dashboard\External;


use App\Http\Controllers\Controller;
use App\Mail\ElavonPaymentDetails;
use App\Mail\ExternalWelcomeEmail;
use App\Mail\NotificationEmail;
use App\Mail\paymentCapture;
use App\Mail\PaymentMethodAccessMail;
use App\Mail\WelcomeEmail;
use App\Models\Charge;
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

    public function registerForm()
    {
        return view('auth.externalregister');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        try {
            DB::beginTransaction();

            $user = User::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => Role::where('name', 'external')->first()->id,
            ]);

            $paymentMethodAccess = PaymentMethodAccess::create([
                'user_id' => $user->id,
                'company_name' => $request->company_name,
                'fee' => setting('payment.payment_method_fee')

            ]);
            $paymentMethodAccess->createMeta('title', $request->title);

            Mail::to($user->email)->send(new ExternalWelcomeEmail(['email' => $user->email, 'url' => route('login'), 'password' => 'HIDDEN']));
            DB::commit();
            Auth::login($user);

            return redirect()->route('external.dashboard');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function startSubscription(Subscription $subscription)
    {
        if ($subscription->subscribable->user_id != auth()->id())
            return abort(403);
        try {

            DB::beginTransaction();
            $subscription_fee = $subscription->fee;
            $subscribe = (new Subscribe())->subscription();

            $subscribe = $subscribe->getUrl($subscription_fee, false, [
                'continueurl' => route('external.subscription.success', $subscribe->subscription->id),
                'cancelurl' => route('external.subscription.cancel', $subscribe->subscription->id)
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

                        $paymentMethodAccess = $subscriptionDatabase->subscribable;
                        $paymentMethodAccess->status = true;
                        $paymentMethodAccess->key = Str::uuid();
                        $paymentMethodAccess->last_paid_at = now();
                        $paymentMethodAccess->save();
                    }
                }
            };
            DB::commit();
            Mail::to($paymentMethodAccess->user->email)->send(new PaymentMethodAccessMail($paymentMethodAccess));
            Mail::to(setting('site.email'))->send(new PaymentMethodAccessMail($paymentMethodAccess));

            return redirect()->route('external.contract')->with('success', 'Subscription completed');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('external.contract')->withErrors($e->getMessage());
        } catch (Error $e) {
            DB::rollBack();
            return redirect()->route('external.contract')->withErrors($e->getMessage());
        }
    }

    public function dashboard()
    {
        $paymentMethodAccesses = PaymentMethodAccess::where('user_id', auth()->id())->get();
        return view('dashboard.external.index', compact('paymentMethodAccesses'));
    }
    public function edit()
    {

        $paymentMethodAccess = auth()->user()->paymentMethodAccess;
        return view('dashboard.external.edit', compact('paymentMethodAccess'));
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
        $paymentMethodAccess = auth()->user()->paymentMethodAccess;

        $paymentMethodAccess->update([
            'company_name' => $request->company_name,
            'company_email' => $request->company_email,
            'company_address' => $request->company_address,
            'company_domain' => $request->company_domain,
            'company_registration' => $request->company_registration,
        ]);

        return view('dashboard.external.edit', compact('paymentMethodAccess'));
    }

    public function paymentMethodAccess()
    {


        $paymentMethodAccess = auth()->user()->paymentMethodAccess;

        // if ($paymentMethodAccess && $paymentMethodAccess->last_paid_at == null) {
        //     return redirect(auth()->user()->paymentMethodAccess->subscription->url);
        // }
        // if ($paymentMethodAccess->user_id != auth()->id()) abort(403);
        $subscription = $paymentMethodAccess->subscription->key;
        $subscriptionQuickpay = (new Subscribe())->subscription($subscription)->subscription;

        return view('dashboard.external.paymentMethodAccess', compact('paymentMethodAccess', 'subscriptionQuickpay'));
    }


    public function charges()
    {

        $paymentMethodAccess = auth()->user()->paymentMethodAccess;
        if ($paymentMethodAccess->user_id != auth()->id())
            abort(403);
        $charges = $paymentMethodAccess->subscription->charges()->latest()->paginate(10);

        return view('dashboard.external.charges', compact('paymentMethodAccess', 'charges'));
    }

    public function contract()
    {

        $paymentMethodAccess = auth()->user()->paymentMethodAccess;
        if ($paymentMethodAccess->user_id != auth()->id())
            abort(403);

        return view('dashboard.external.contract', compact('paymentMethodAccess'));
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
        $pdf = Pdf::loadView('dashboard.external.pdf.invoice', ['charge' => $charge, 'tax' => $tax, 'base_price' => $base_price]);
        $fileName = 'invoice/invoice' . uniqid() . '.pdf';
        try {
            return $pdf->download($fileName);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function signContract(Request $request, PaymentMethodAccess $paymentMethodAccess)
    {


        $message = 'Company Name: ' . $paymentMethodAccess->company_name . '<br> ' .
            'Org number: ' . $paymentMethodAccess->company_registration . '<br>' .
            'Company email: ' . $paymentMethodAccess->company_email . '<br>' .
            'Contact person: ' . $paymentMethodAccess->user->name . ' ' . $paymentMethodAccess->user->last_name . ' <br>' .
            'Phone: ' . $paymentMethodAccess->user->phone . '<br>
        <b> Selected payment Methods</b> <br>' . $request->visa .
            ' <br>' . $request->mastercard . '<br> ' . $request->vipps . '<br> ' . $request->google_pay . '<br> ' . $request->apple_pay . '<br> ' . $request->amex;
        $mail_data = [
            'subject' => $paymentMethodAccess->company_name . ' has submited payment methods',
            'body' => $message,
            'button_link' => $paymentMethodAccess->company_domain,
            'button_text' => 'View Shop',
            'emails' => [],
        ];

        $paymentMethodAccess->update([
            'paymentMethod' => $request->filled('vipps')   ? 'quickpay' : 'elavon',
            'contract_signed' => 1
        ]);

        Mail::to(setting('site.email'))->send(new NotificationEmail($mail_data));
        if ($request->filled('B2B')) {
            return redirect()->route('shop.setup_payment_two');
        }
        if ($paymentMethodAccess->paymentMethod == 'quickpay') {
            $response = Http::post(
                'https://hooks.zapier.com/hooks/catch/2912165/38jaejy',
                [
                    'shop_id' => $paymentMethodAccess->key,
                    'first_name' => $paymentMethodAccess->user->name,
                    'last_name' => $paymentMethodAccess->user->last_name,
                    'shop_name' => $paymentMethodAccess->company_name,
                    'title' => $paymentMethodAccess->title,
                    'company_name' => $paymentMethodAccess->company_name,
                    'company_url' => $paymentMethodAccess->company_domain,
                    'company_registration' => $paymentMethodAccess->company_registration,
                    'email' => $paymentMethodAccess->company_email,
                    'phone' => $paymentMethodAccess->user->phone,
                    'city' => $paymentMethodAccess->company_address->city,
                    'street' => $paymentMethodAccess->company_address->street,
                    'post_code' => $paymentMethodAccess->company_address->zip,
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
            return redirect()->route('external.setup_elavon_payment');
        }


        return back();
    }
    public function settings()
    {

        return view('dashboard.external.settings');
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
            return redirect()->route('external.settings')->withErrors('The old password is incorrect.');
        }

        // Hash and update the new password
        $user->password = Hash::make($request->new_pass);
        $user->save();

        return redirect()->route('external.dashboard')->with('success', 'Password changed successfully.');
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
        return view('dashboard.external.complete');
    }
    public function completeProfileStore(Request $request)
    {
        $request->validate([
            'company_email' => ['required', 'string', 'max:255'],
            'company_address.city' => ['required', 'string', 'max:255'],
            'company_address.street' => ['required', 'string', 'max:255'],
            'company_address.zip' => ['required', 'string', 'max:255'],
            'company_registration' => ['required', 'string', 'max:255'],
            'company_domain' => ['required', 'url', 'max:255'],
        ]);

        $subscription_fee = auth()->user()->paymentMethodAccess->fee();
        auth()->user()->paymentMethodAccess->update([
            'company_email' => $request->company_email,
            'company_address' => $request->company_address,
            'company_domain' => $request->company_domain,
            'company_registration' => $request->company_registration,
        ]);
        $subscribe = (new Subscribe())->subscription();

        $subscribe = $subscribe->getUrl($subscription_fee, false, [
            'continueurl' => route('external.subscription.success', $subscribe->subscription->id),
            'cancelurl' => route('external.subscription.cancel', $subscribe->subscription->id)
        ]);

        $subscription = auth()->user()->paymentMethodAccess->subscription()->create([
            'key' => $subscribe['data']['payment_id'],
            'url' => $subscribe['data']['url'],
            'fee' => $subscription_fee
        ]);

        return redirect($subscription->url);
    }



    public function setup_elavon_payment()
    {

        $external = auth()->user()->paymentMethodAccess;

        if ($external->paymentMethod == 'elavon' && $external->elavon_payment_setup == true || $external->elavon_details_verified_by_shop == true) return redirect()->route('shop.dashboard');
        return view('dashboard.external.payments.elavon_setup', compact('external'));
    }

    public function store_setup_elavon_payment(Request $request)
    {
        $external = auth()->user()->paymentMethodAccess;

        if ($external->paymentMethod == 'elavon' && $external->elavon_payment_setup == true || $external->elavon_details_verified_by_shop == true) return redirect()->route('shop.dashboard');

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
        $external->createMetas($meta);

        $protectedLink = ProtectedLink::updateOrCreate(['link' => route('view_payment_data', ['id' => $external->id, 'type' => 'plugin'])], [
            'link' => route('view_payment_data', ['id' => $external->id, 'type' => 'plugin']),
            'uid' => uniqid(),
            'password' => uniqid()
        ]);

        $external->createMeta('elavon_details_verified_by_shop', false);

        $viewLink = route('view_payment_data', ['id' => $external->id, 'type' => 'plugin', 'uid' => $protectedLink->uid, 'password' => $protectedLink->password]);

        $contactMail = $request->meta['contact_email'];

        Mail::to($contactMail)->send(new paymentCapture($external, $viewLink));
        // try {
        //     // Pass the link to the Mailable
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Failed to send email.']);
        // }
        return redirect()->route('external.dashboard')->with('success', 'Your details have been successfully submitted. Please check your email for confirmation . Thank you .');
    }
    public function viewPaymentData($id)
    {
        $external = PaymentMethodAccess::fid($id);


        // $external = auth()->user()->shop;
        if ($external->elavon_details_verified_by_shop != true) {
            return view('dashboard.external.payments.confrimPaymentCapture', ['shop' => $external]);
        } else {
            return redirect()->route('external.dashboard')->withErrors('You already verified your information');
        }
    }

    public function verifyElavonPayment(Request $request)
    {


        $external = auth()->user()->paymentMethodAccess;
        $shop = $external;
        if ($external->elavon_details_verified_by_shop != true) {
            $pdf = Pdf::loadview('pdf.elavon_payment_shop_details', compact('shop'));
            Mail::to('digitalisertweb@gmail.com')->bcc('didrik.tonnessen@elavon.com')->cc($external->contact_email)->send(new ElavonPaymentDetails($external, $pdf));
            $external->createMeta('elavon_details_verified_by_shop', true);
            $external->createMeta('needKYC', true);
            return redirect()->route('external.dashboard');
        } else {
            return redirect()->route('external.dashboard')->withErrors('You already verified your information');
        }
    }
}
