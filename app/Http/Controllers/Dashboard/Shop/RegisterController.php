<?php

namespace App\Http\Controllers\Dashboard\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopRegisterRequest;
use App\Jobs\ShopWelcomeEmail;
use App\Mail\NotificationEmail;
use App\Mail\ServiceSubscriptionMail;
use App\Mail\ShopInvoice;
use App\Mail\WelcomeEmail;
use App\Models\Charge;
use App\Models\Shop;
use App\Models\User;
use App\Payment\Elavon\ElavonShopSubscription;
use App\Payment\Subscribe;
use App\Rules\CreditCardValidation;
use App\Services\RetailerCommission;
use App\Services\Subscription\ShopSubscriptionService;
use Exception;
use Illuminate\Contracts\Auth\Guard;
use Iziibuy;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use QuickPay\QuickPay;

class RegisterController extends Controller
{

    /**
     * This method return shop register page as response
     *
     * @return void
     */
    public function register_form()
    {
        if (
            request()->filled('refferal') &&
            User::where('role_id', 5)->where('id', request()->refferal)->count() &&
            !Session::has('refferal')
        ) {
            Session::put('refferal', request()->refferal);
        }

        return view('dashboard.shop.auth.register');
    }

    public function register(ShopRegisterRequest $request, Guard $auth)
    {

        $user = DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'last_name' => $request->last_name,
                'role_id' => User::ROLES['Vendor'],
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);

            $shop = Shop::create([
                'is_demo' => true,
                'user_id' => $user->id,
                'user_name' => $request->user_name,
                'retailer_id' => Session::get('refferal'),
                'establishment_cost' => setting('payment.estibliment_cost') ? setting('payment.estibliment_cost') : 1995,
                'monthly_cost' => setting('payment.price_per_shop') ? setting('payment.price_per_shop') : 299,
                'service_establishment_cost' => setting('payment.service_establishment_cost') ? setting('payment.service_establishment_cost') : 1995,
                'service_monthly_fee' => setting('payment.service_monthly_cost')  ? setting('payment.service_monthly_cost') : 299,
                'per_user_fee' => setting('payment.price_per_user') ? setting('payment.price_per_user') : 99,
                'terms' => setting('terms.no'),
                'subscriptionMethod' => 'quickpay'
            ]);

            $shop->createMetas([
                'name' => $request->company_name,
                'company_name' => $request->company_name,
                'title' => $request->title,
                'logo'  => 'defaults/shop_default_logo.png',
                'shop_color' => '#203864',
                'shop_bottom_color' => '#203864',
                'header_color' => '#96afe8',
                'menu_color' => '#203864',
                'menu_hover_color' => '#203864',
                'top_header_language_text_color' => '#203864',
                'top_header_language_text_hover_color' => '#96afe8',
                'top_header_search_bar_text_color' => '#203864',
                'top_header_search_bar_bg_color' => '#ffffff',
                'top_header_search_btn_text_color' => '#ffffff',
                'top_header_search_btn_hover_color' => '#000000',
                'footer_bg_color' => '#96afe8',
                'footer_text_color' => '#ffffff',
                'footer_text_hover_color' => '#f1f1f1',
                'buy_btn_bg_color' => '#3fa24f',
                'buy_btn_text_color' => '#ffffff',
                'buy_btn_hover_color' => '#ffffff',
            ]);

            $user->update([
                'shop_id'   => $user->shop->id,
            ]);

            return $user;
        });
        $message = $user->name . ' ' . $user->last_name . ' has created new shop ' . $user->shop_name;
        $mail_data = [
            'subject' => 'New shop registered',
            'body' => $message,
            'button_link' => route('voyager.shops.edit', $user->shop->id),
            'button_text' => 'View Shop',
            'emails' => [],
        ];

        Mail::to(setting('site.email'))->send(new NotificationEmail($mail_data));
        //send email to shop
        $message = 'Welcome! <br>
         Thank you for signing up with us.<br>
         Your new account has been setup and you can now login to your area using the details below.<br>
         Url For Your Shop: ' . route('shop.home', ['user_name' => $user->shop->user_name]) . '<br> Email Address: ' . $user->email . ' <br>Password: HIDDEN';
        $mail_data = [
            'subject' => 'Thank you for creating new shop',
            'body' => $message,
            'button_link' => route('shop.home', ['user_name' => $user->shop->user_name]),
            'button_text' => 'View Shop',
            'emails' => [],
        ];

        // Mail::to($user->email)->send(new WelcomeEmail(['email' => $user->email, 'url' => route('shop.home', ['user_name' => $user->shop->user_name]), 'password' => 'HIDDEN']));
        //Mail::to($user->email)->send(new NotificationEmail($mail_data));

        session()->forget('refferal');

        $auth->login($user);

        return redirect()->route('shop.dashboard');
    }

    public function updateProfile(Request $request)
    {
        $shop = auth()->user()->shop;
        $shop->update([
            'country' => $request->country,
            'user_name' => $request->user_name,
            'default_currency' => $request->default_currency,
            'currencies' => json_encode($request->currencies),
            'selling_location_mode' => $request->selling_location_mode
        ]);
        $shop->createMetas($request->meta);

        session()->flash('success', 'profile updated succesfully');
        if (auth()->user()->shop->status) {
            return redirect()->back();
        } else {
            return redirect()->route('shop.subscription.payment');
        }
    }

    public function completeProfile()
    {
        $shop = auth()->user()->shop;
        return view('dashboard.shop.profile-complete', compact('shop'));
    }

    public function completeProfileUpdate(Request $request)
    {
        $request->validate(
            [
                'country' => ['required', 'string', 'max:20'],
                'city' => ['required', 'string', 'max:20'],
                'street' => ['required', 'string', 'max:40'],
                'post_code' => ['required', 'string', 'max:10'],
                'contact_email' => ['required', 'email', 'string', 'max:50'],
                'contact_phone' => ['required', 'string', 'max:15'],
                'company_registration' => ['required', 'string', 'max:30'],
                // 'card_holder_name' => ['required', new CreditCardValidation],
                // 'card_number' => ['required', new CreditCardValidation],
                // 'expiration_month' => ['required', new CreditCardValidation],
                // 'expiration_year' => ['required', new CreditCardValidation],
                // 'ccv' => ['required', new CreditCardValidation],
            ]
        );
        try {
            $user = auth()->user();
            $shop = $user->shop->createMetas([
                'country' => $request->country,
                'company_registration' => $request->company_registration,
                'city' => $request->city,
                'street' => $request->street,
                'post_code' => $request->post_code,
                'contact_email' => $request->contact_email,
                'contact_phone' => $request->contact_phone,
                // 'card_holder_name' => $request->card_holder_name,
                // 'card_number' => $request->card_number,
                // 'expiration_month' => $request->expiration_month,
                // 'expiration_year' => $request->expiration_year,
                // 'ccv' => $request->ccv
            ]);

            return redirect()->route('shop.subscription.payment');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
        return redirect()->back()->withErrors('Something went wrong');
    }
    public function subscriptionIndex()
    {
        if (auth()->user()->role_id == 3) {
            return view('dashboard.shop.subscription');
        }
        return redirect(route('home'));
    }
    public function deleteAccount()
    {
        auth()->user()->delete();
        return redirect(route('home'))->withErrors('Account Deleted');
    }
    public function enrollSubscription()
    {


        $shop = auth()->user()->shop;

        $api =  setting('payment.api_key');
        $quickPay = new Subscribe($api);
        if (request()->has('type')) {
            $shop->update([
                'subscription_id' => null
            ]);
        }
        if (!request()->has('type') && $shop->subscription_id) {

            $amount = Iziibuy::round_num($shop->subscriptionFee());
            $payment = $quickPay->subscription($shop->subscription_id)->charge($amount);


            if ($payment['status'] == true) {

                if (isset($payment['data']->id)) {
                    $payment_check = $quickPay->payment($payment['data']->id);

                    if ($payment_check['status'] == true && $payment_check['data']->state == 'processed') {
                        $charge = Charge::create([
                            'shop_id' => $shop->id,
                            'order_id' =>  $payment['data']->id,
                            'amount' => $amount,
                            'status' => true,
                            'comment' => 'subscription fee',
                            'details' => json_encode($shop->subscriptionFeeDetails())
                        ]);
                    }
                }

                if ($payment_check['data']->test_mode == false) {
                    $shop->is_demo = false;
                } else {
                    $shop->is_demo = true;
                }
                $shop->status = 1;
                $shop->establishment = 1;
                $shop->paid_at = Carbon::now();
                $shop->save();
                if ($shop->retailer_id) {
                    RetailerCommission::commission_from_recurring_payments($shop)->pay();
                }
                return redirect(route('shop.dashboard'));
            }
            return redirect(route('shop.subscription.payment'))->withErrors('There is a problem with your Payment method. Please try again later');
        }
        try {

            $subscription = $quickPay->subscription()->getUrl(Iziibuy::round_num($shop->subscriptionFee()), true);
            if ($subscription['status'] == true) {
                $shop->payment_url = $subscription['data']['url'];
                $shop->subscription_id = $subscription['data']['payment_id'];
                $shop->save();
                return redirect($shop->payment_url);
            } else {
                throw new Exception('Subscription request failed');
            }
        } catch (\Exception $e) {
            return redirect(route('shop.subscription.payment'))->withErrors('There is some problem with your payment. Please contact support');
        }
    }
    public function confirmSubscription($subscription_id)
    {
        $api = setting('payment.api_key');
        $quickPay = new Subscribe($api);


        $subscription = $quickPay->subscription($subscription_id)->get();

        if ($subscription['data']->accepted == true) {
            $shop = auth()->user()->getShop();

            $shop->subscription_id = $subscription['data']->id;
            $shop->save();

            if ($shop->status == 1) {
                return redirect(route('shop.complete.signup'))->with('Thank your for subscribe');
            }
            if ($shop->paid_at) {
                if ($shop->paid_at->isSameMonth(today())) {
                    $shop->status = 1;
                    $shop->establishment = 1;
                    return redirect(route('shop.dashboard'))->with('Thank your for subscribe');
                }
            }

            $amount = Iziibuy::round_num($shop->subscriptionFee());

            $charge_status = $quickPay->subscription($subscription_id)->charge($amount);

            if ($charge_status['status']) {
                $payment =  $quickPay->payment($charge_status['data']->id);
                Mail::to($shop->user->email)->send(new ShopInvoice($shop));

                if ($payment['data']->state == 'processed') {
                    Charge::create([
                        'shop_id' => $shop->id,
                        'order_id' =>  $charge_status['data']->id,
                        'amount' => $amount,
                        'status' => true,
                        'comment' => 'subscription fee',
                        'details' => json_encode($shop->subscriptionFeeDetails())
                    ]);
                    if ($charge_status['data']->test_mode == false) {
                        $shop->is_demo = false;
                    } else {

                        $shop->is_demo = true;
                    }
                    $shop->status = 1;
                    $shop->establishment = 1;
                    $shop->paid_at = Carbon::now();
                    if ($shop->retailer_id) {
                        RetailerCommission::one_time_pay_out($shop)->pay();
                        RetailerCommission::commission_from_recurring_payments($shop)->pay();
                    }
                    $shop->save();
                }

                return redirect(route('shop.complete.signup'))->with('Thank your for subscribe');
            }
        }



        return redirect(route('shop.subscription.payment'))->withErrors('There is a problem with your Payment method. Please try again later');
    }
    //     public function confirmSubscription($subscription_id)
    //     {
    //         $shop = Shop::where('subscription_id', $subscription_id)->orWhere('shopperId', $subscription_id)->first();
    // dd($shop);
    //         return ShopSubscriptionService::confirmSubscription($shop);
    //     }

    public function serviceSubscription()
    {
        $shop = Auth::user()->shop;


        if ($shop->can_provide_service) abort('403', 'You already subscribed for service');
        return view('dashboard.shop.subscribe', compact('shop'));
    }
    public function serviceSubscribe()
    {
        $shop = Auth::user()->shop;

        if ($shop->can_provide_service) abort('403', 'You already subscribed for service');
        try {

            $fee = $shop->ServiceSubscriptionFee();
            $api = setting('payment.api_key');
            $quickPay = new Subscribe($api);


            $charge = $quickPay->subscription($shop->subscription_id)->charge($fee);

            if ($charge['status']) {
                $payment =  $quickPay->payment($charge['data']->id);

                if ($payment['data']->state == 'processed') {
                    Charge::create([
                        'shop_id' => $shop->id,
                        'order_id' =>  $charge['data']->id,
                        'amount' => $fee,
                        'status' => true,
                        'comment' => 'Service subscription',

                    ]);
                } else {
                    throw new Exception('Subscription attempt failed');
                }
            }

            Mail::to($shop->user->email)->send(new ServiceSubscriptionMail($shop));

            $shop->update([
                'can_provide_service' => 1,
                'service_establishment' => 1
            ]);

            return redirect()->route('shop.dashboard')->with('success', 'Now you can provide service');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
