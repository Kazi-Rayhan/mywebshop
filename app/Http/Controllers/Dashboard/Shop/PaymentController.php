<?php

namespace App\Http\Controllers\Dashboard\Shop;

use App\Http\Controllers\Controller;
use App\Mail\ElavonPaymentDetails;
use App\Mail\NotificationEmail;
use App\Mail\OrderConfirmed;
use App\Mail\paymentCapture;
use App\Models\EnterpriseOnboarding;
use App\Models\Order;
use App\Models\PaymentMethodAccess;
use App\Models\ProtectedLink;
use App\Payment\Quickpay\QuickPayPayment;
use App\Payment\Two\TwoPayment;
use App\Services\RetailerCommission;
use App\Two\Two;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Shop;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function setup_payment_two()
    {

        return view('dashboard.shop.payments.two_trail');
    }

    public function completeSignup()
    {
        return view('dashboard.shop.complete-signup');
    }
    public function postCompleteSignup(Request $request)
    {
        $shop = auth()->user()->shop;
        $message = 'Company Name: ' . $shop->company_name . '<br> ' . 'Org number: ' . $shop->company_registration . '<br>' . 'Company email: ' . $shop->user->email . '<br>' . 'Contact person: ' . $shop->user->name . ' ' . $shop->user->last_name . ' <br>' . 'Phone: ' . $shop->user->phone . '<br><b> Selected payment Methods</b> <br>' . $request->visa . ' <br>' . $request->mastercard . '<br> ' . $request->vipps;
        $mail_data = [
            'subject' => $shop->name . ' has submited payment methods',
            'body' => $message,
            'button_link' => route('shop.home', ['user_name' => $shop->user_name]),
            'button_text' => 'View Shop',
            'emails' => [],
        ];
        $shop->update([
            'paymentMethod' => $request->filled('vipps')  ? 'quickpay' : 'elavon',
            'contract_signed' => 1
        ]);

        if ($request->filled('B2B')) {
            return redirect()->route('shop.setup_payment_two');
        }
        if ($shop->paymentMethod == 'quickpay') {
            Mail::to(setting('site.email'))->cc('no-reply@iziimail.com')->send(new NotificationEmail($mail_data));

            $response = Http::post('https://hooks.zapier.com/hooks/catch/2912165/3mz0sl1/', [
                'shop_id' => $shop->id,
                'first_name' => $shop->user->name,
                'last_name' => $shop->user->last_name,
                'shop_name' => $shop->name,
                'title' => $shop->title,
                'company_name' => $shop->company_name,
                'company_url' =>  $shop->company_url ? $shop->company_url : route('shop.home', $shop->user_name),
                'company_registration' => $shop->company_registration,
                'email' => $shop->user->email,
                'phone' => $shop->user->phone,
                'city' => $shop->city,
                'street' => $shop->street,
                'post_code' => $shop->post_code,
                'visa' => $request->visa ? true : false,
                'mastercard' => $request->mastercard ? true : false,
                'vipps' => $request->vipps ? true : false
            ]);
        } else {
            return redirect()->route('shop.setup_elavon_payment');
        }



        return back();
    }
    function quickpayWebhook(Request $request)
    {
        $expectedPassword = 'jk4#sdfgdvsdfg';

        $password = $request->header('X-Webhook-Password');

        if ($password !== $expectedPassword) {
            return response()->json(['message' => 'Invalid password'], 401);
        }
        $request->validate([
            'shop_id' => ['required', 'exists:shops,id'],
            'contract_url' => ['required', 'string', 'max:255'],
            'contract_status' => ['required', 'boolean'],
            'contract_signed' => ['required', 'boolean'],
            'kyc_status' => ['required', 'boolean'],
        ]);

        $shop = Shop::find($request->shop_id);

        if ($shop) {
            $shop->update([
                'contract_url' => $request->input('contract_url'),
                'contract_status' => $request->input('contract_status'),
                'contract_signed' => $request->input('contract_signed'),
                'kyc_status' => $request->input('kyc_status'),
            ]);
            $shop->createMeta('quickpay_api_key', $request->api_key);
            $shop->createMeta('quickpay_secret_key', $request->secret_key);

            return response()->json(['message' => 'Shop updated successfully']);
        }

        return response()->json(['message' => 'No shop found'], 404);
    }
    function quickpayPluginWebhook(Request $request)
    {
        $expectedPassword = 'jk4#sdfgdvsdfg';

        $password = $request->header('X-Webhook-Password');

        if ($password !== $expectedPassword) {
            return response()->json(['message' => 'Invalid password'], 401);
        }
        $request->validate([
            'id' => ['required'],
            'contract_url' => ['required', 'string', 'max:255'],
            'contract_status' => ['required', 'boolean'],
            'contract_signed' => ['required', 'boolean'],
            'kyc_status' => ['required', 'boolean'],
        ]);

        $plugin = PaymentMethodAccess::where('key', $request->id)->first();

        if ($plugin) {
            $plugin->update([
                'contract_url' => $request->input('contract_url'),
                'contract_status' => $request->input('contract_status'),
                'contract_signed' => $request->input('contract_signed'),
                'kyc_status' => $request->input('kyc_status'),
                'quickpay_api_key' => $request->quickpay_api_key,
                'quickpay_secret_key' => $request->quickpay_secret_key,
            ]);

            return response()->json(['message' => 'Plugin updated successfully']);
        }

        return response()->json(['message' => 'No plugin found'], 404);
    }
    public function store_setup_payment_two(Request $request)
    {

        $shop = auth()->user()->shop;
        if ($request->hasFile('brand_logo')) {
            $brand_logo = $request->file('brand_logo')->store('logo');
        } else {
            $brand_logo = $shop->logo;
        }
        if ($request->brand_website) {
            $website = $request->brand_website;
        } else {
            $website = route('shop.home', $shop->user_name);
        }
        try {
            $data = [
                'short_name' => $shop->user_name,

                'national_id' => $request->company_number,
                'legal_name' => $request->company_name,
                'email' => $request->email,
                'email_erp' => $request->email,
                'email_invoice' => $request->invoice_email,
                'phone' => $request->phone,
                'phone_invoice' => $request->invoice_phone,
                'website' => $website,
                'address_lines' => $request->city . ', ' . $request->street . ', ' . $request->post_code,
                'address_city' => $request->city,
                'address_postal_code' => $request->post_code,
                'address_country_code' => $request->country,
                // 'fixed_fee_per_order' => '0.0',
                // 'percentage_fee_per_order' => '2.0',
                'country_code' => $request->country,
                'payment_provider_details' => [
                    'bank_account' => [
                        'description' => $request->name,
                        'bban' => $request->bban,
                        'iban' => $request->iban,
                        'bic' => $request->bic,
                        'country_code' => $request->country,
                    ],
                ],
            ];
            if (Storage::exists($brand_logo)) {
                $data['logo_path'] = Storage::url($brand_logo);
            }

            $response = (new Two($data))->marketplace();
            if (isset($response->error_code)) {
                throw new Exception($response->error_details);
            }
            $shop->createMetas(['two_api_key' => $response->secret_api_key]);
            $shop->createMetas(['two_merchant_id' => $response->id]);
            $shop->createMeta('two_form_submited', 1);
            $shop->createMeta('two_merchant_status', 0);
            $shop->save();
            $external_link = $response->payee_accounts[0]->external_ref_url;
            $company_registration = $shop->company_registration;
            $mail_data = [
                'name' => $shop->user->name . ' ' . $shop->user->last_name,
                'subject' => 'Request sent for two payment',
                'body' => "Vi i Two samarbeider med 2izii for å tilby effektiv fakturering av bedriftskunder. Med bedriftsfaktura fra Two får bedriftskundene faktura på EHF og på epost. Two sin finanspartner Aprila Bank finansierer fakturaene og sammen tar vi oss av alt fra kredittsjekking og verifisering samt betalingsoppfølgning. <br> <br>
                    Det siste steget i vår onboardingsprosess gjennomføres med vår finanspartner Aprila Bank via følgende lenke: <a href='$external_link'>$external_link</a> <br><br>
                    Søknaden må signeres av en selskapsrepresentant med signaturrett alene. <br><br>
                    Søk gjerne opp selskapet i Brønnøysundregistrene her: <a href='https://w2.brreg.no/enhet/sok/detalj.jsp?orgnr=$company_registration'>https://w2.brreg.no/enhet/sok/detalj.jsp?orgnr=$company_registration</a> for å finne ut hvilke personer som har mulighet til å signere på vegne av selskapet.<br><br>
                    Så fort søknaden hos Aprila Bank er godkjent blir Two aktivert som betalingsmetode i din nettbutikk.
                    Dersom det er noe du lurer på finner du ofte stilte spørsmål og svar her. Nøl ikke med å ta kontakt med oss på support@two.inc dersom du har spørsmål tilknyttet onboardingsprosessen med Aprila Bank og Two!<br><br>
                    Husk at søknaden hos Aprila Bank ikke kan signeres av bedrifter hvor det kreves signatur fra flere enn en person.<br>
                    Her er link til TWO’s terms and conditions både for selger og kjøper<br>
                    Med vennlig hilsen<br>
                    Two og 2izii",
                'button_link' => route('shop.setup_payment_two'),
                'button_text' => 'Two Application Status',
                'emails' => [],
            ];
            Mail::to($shop->user->email)->send(new NotificationEmail($mail_data));
            return back()->with('success', 'Two Api Registration Success')->with('external_ref_url', $response->payee_accounts[0]->external_ref_url);
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function orderFulfilled(Order $order)
    {
        try {
            if ($order->payment_method == 'two') {
                $res = (new TwoPayment($order->shop, $order))->fulfilled();
                return redirect()->back()->with('success', 'Order is fulfilled');
            } else {
                throw new Exception('Order cant be fulfiled');
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
    public function orderCancel(Order $order)
    {
        try {

            if ($order->payment_status == 1 && $order->status != 2) {
                $res = (new TwoPayment($order->shop, $order))->cancel();

                return redirect()->back()->with('success', 'Order is canceled');
            } else {
                throw new Exception('Order cant be canceld');
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function refundView(Order $order)
    {
        return view('dashboard.shop.order.refund', compact('order'));
    }
    public function refund(Request $request, Order $order)
    {
        $request->validate([
            'amount' => 'required|max:' . $order->maxRefund(),
            'reason' => 'nullable|string'
        ]);
        try {
            (new TwoPayment($order->shop, $order))->refund($request->amount, $request->reason);
            return redirect()->back()->with('success', 'Refund done');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function captureOrder(Order $order)
    {
        if (request()->shipped == 0) {
            return back();
        }
        try {
            define('ORDER_DO_NOT_BELONGS_TO_THIS_SHOP', $order->shop_id != auth()->user()->shop->id);
            define('ORDER_IS_NOT_CAPTURED', $order->status != 4);

            if (ORDER_DO_NOT_BELONGS_TO_THIS_SHOP || ORDER_IS_NOT_CAPTURED) {
                throw new Exception('Payment Capture Failed');
            };


            define('ENDPOINT_FOR_DETAILS', sprintf("/payments/%s", $order->payment_id));
            $payment_details = (new QuickPayPayment($order))->paymentStatus($order->payment_id);

            if ($payment_details['data']['state'] == 'new') {

                $payment_capture = (new QuickPayPayment($order))->capture();

                if ($payment_capture['data']['accepted'] == true) {


                    $order->status = 5;
                    $order->save();
                    $order->payment_status = 1;

                    if ($order->shop->retailer_id) {
                        // if ($order->shop->retailer_id && $payment_details['data']['test_mode'] != true) {
                        RetailerCommission::commission_from_sales($order)->pay();
                    }
                    $message =  'Order placed on ' . $order->created_at->format('M d, Y') . ' has been confirmed.';
                    Mail::to($order->email)->send(new OrderConfirmed($order, $message, true, null));
                } else {
                    throw new Exception('Payment Capture Failed');
                }
            } elseif ($payment_details['data']['state'] == 'processed') {
                $order->status = 5;
                $order->payment_status = 1;
                $order->save();

                if ($order->shop->retailer_id) {
                    // if ($order->shop->retailer_id && $payment_details['data']['test_mode'] != true) {
                    RetailerCommission::commission_from_sales($order)->pay();
                }
                $message =  'Order placed on ' . $order->created_at->format('M d, Y') . ' has been confirmed.';
                Mail::to($order->email)->send(new OrderConfirmed($order, $message, null, true));
            } else {
                throw new Exception('Payment Capture Failed');
            }


            return redirect()->back()->with('success', 'Payment Captured');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    public function setup_elavon_payment()
    {
        $shop = auth()->user()->getShop();
        if ($shop->paymentMethod == 'elavon' && $shop->elavon_payment_setup == true || $shop->elavon_details_verified_by_shop == true) return redirect()->route('shop.dashboard');
        return view('dashboard.shop.payments.elavon_setup');
    }

    public function store_setup_elavon_payment(Request $request)
    {

        $shop = auth()->user()->shop;

        if ($shop->paymentMethod == 'elavon' && $shop->elavon_payment_setup == true || $shop->elavon_details_verified_by_shop == true) return redirect()->route('shop.dashboard');

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
        $shop->createMetas($meta);

        $protectedLink = ProtectedLink::updateOrCreate(['link' => route('view_payment_data', ['id' => $shop->id, 'type' => 'shop'])], [
            'link' => route('view_payment_data', ['id' => $shop->id, 'type' => 'shop']),
            'uid' => uniqid(),
            'password' => uniqid()
        ]);

        $shop->createMeta('elavon_details_verified_by_shop', false);

        $viewLink = route('view_payment_data', ['id' => $shop->id, 'uid' => $protectedLink->uid, 'password' => $protectedLink->password, 'type' => 'shop']);
        $contactMail = $request->meta['contact_email'];
        Mail::to($contactMail)->send(new paymentCapture($shop, $viewLink));
        // try {
        //     // Pass the link to the Mailable
        // } catch (\Exception $e) {
        //     return response()->json(['error' => 'Failed to send email.']);
        // }
        return redirect()->route('shop.dashboard')->with('success', 'Your details have been successfully submitted. Please check your email for confirmation . Thank you .');
    }
    public function viewPaymentData($type, $id)
    {

        if ($type == 'plugin') {
            $shop = PaymentMethodAccess::findOrFail($id);
            if ($shop->user_id != auth()->id()) abort(403);
            if ($shop->elavon_details_verified_by_shop != true) {
                return view('dashboard.external.payments.confrimPaymentCapture', ['shop' => $shop]);
            } else {
                return redirect()->route('external.dashboard')->withErrors('You already verified your information');
            }
        } elseif ($type == 'enterprise') {
            $enterprise = EnterpriseOnboarding::findOrFail($id);
            
            if ($enterprise->user_id != auth()->id()) abort(403);
            if ($enterprise->elavon_details_verified_by_shop != true) {
                return view('dashboard.enterprise.payments.confrimPaymentCapture', ['enterprise' => $enterprise]);
            } else {
                return redirect()->route('external.dashboard')->withErrors('You already verified your information');
            }
        } else {
            $shop = Shop::findOrFail($id);
            if ($shop->user_id != auth()->id()) abort(403);
            if ($shop->elavon_details_verified_by_shop != true) {
                return view('dashboard.shop.payments.confrimPaymentCapture', ['shop' => $shop]);
            } else {
                return redirect()->route('shop.dashboard')->withErrors('You already verified your information');
            }
        }


        // $shop = auth()->user()->shop;

    }

    public function verifyElavonPayment(Request $request)
    {


        $shop = auth()->user()->shop;
        if ($shop->elavon_details_verified_by_shop != true) {
            $pdf = Pdf::loadview('pdf.elavon_payment_shop_details', compact('shop'));
            Mail::to('digitalisertweb@gmail.com')->bcc('didrik.tonnessen@elavon.com')->cc($shop->contact_email)->send(new ElavonPaymentDetails($shop, $pdf));
            $shop->createMeta('elavon_details_verified_by_shop', true);
            $shop->createMeta('needKYC', true);
            return redirect()->route('shop.dashboard');
        } else {
            return redirect()->route('shop.dashboard')->withErrors('You already verified your information');
        }
    }
}
