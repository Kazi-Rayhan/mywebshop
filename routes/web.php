<?php

use App\Http\Controllers\CallbackController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\Dashboard\External\DashboardController as ExternalController;
use App\Http\Controllers\Dashboard\Shop\TicketController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Dashboard\Shop\DashboardController;
use App\Http\Controllers\Dashboard\Shop\PaymentController;
use App\Mail\NotificationEmail;
use App\Mail\OrderConfirmed;
use App\Mail\OrderDelivered;
use App\Mail\ShopInvoice;
use App\Models\Charge;
use App\Models\Enterprise;
use App\Models\EnterpriseOnboarding;
use App\Models\Order;
use App\Models\Product;
use App\Models\RetailerEarning;
use App\Models\RetailerMeta;
use App\Models\Shipping;
use App\Models\Shop;
use App\Models\Slider;
use App\Models\Subscription;
use App\Models\User;
use App\Payment\Felix\FelixPayment;
use App\Payment\Subscribe;
use App\Services\RetailerCommission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use QuickPay\QuickPay;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use TCG\Voyager\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::get('/', function () {
    $user_name = env('default_username');

    if ($user_name) {

        if (request('manager_id')) {
            session()->put('manager_id', request('manager_id'));
        }
        $shop = Shop::where('user_name', $user_name)->first();
        $sliders = Slider::all();
        request()->merge(['user_name' => $user_name]);
        $new_products = Product::where('featured', 1)->with('ratings')->latest()->limit(8)->whereNull('parent_id')->get();
        return view('shop.home', compact('shop', 'new_products', 'sliders'));
    } else {
        return view('welcome');
    }
})->name('home');


Route::group(['controller' => App\Http\Controllers\Dashboard\Shop\RegisterController::class, 'middleware' => 'permission:enterprise,shop_register'], function () {
    Route::get('/register-as-shop', [App\Http\Controllers\Dashboard\Shop\RegisterController::class, 'register_form'])->name('shop.register');
    Route::post('/register-as-shop', [App\Http\Controllers\Dashboard\Shop\RegisterController::class, 'register'])->name('shop.register.post');
});
Route::get('/register-as-external', [ExternalController::class, 'registerForm'])->middleware('guest')->name('external.register');
Route::post('/register-as-external', [ExternalController::class, 'register'])->middleware('guest')->name('external.register.post');

Route::get('posts/{slug}', [HomeController::class, 'posts'])->name('posts');
Route::get('page/{slug}', [HomeController::class, 'pages'])->name('pages');
Route::get('shop-coupon', [CouponController::class, 'shopCoupon'])->name('shop.coupon');
Route::get('shop-delete-coupon', [CouponController::class, 'destroy'])->name('coupon.destroy');

Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact-store', [HomeController::class, 'contact_store'])->name('contact.store');

Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('faqs', [HomeController::class, 'faqs'])->name('faqs');

Route::resource('tickets', TicketController::class);
Route::post('ticket/reply/{ticket}', [TicketController::class, 'reply'])->name('ticket.reply');
Route::get('ticket/close/{ticket}', [TicketController::class, 'close'])->name('ticket.close');

Route::post('send-message/{user}', [MessageController::class, 'send_message'])->name('send.message');
Route::get('send-order-notification', [HomeController::class, 'send_order_notification'])->name('send.order.notification');



Route::post('/newsletter/subscribe', [HomeController::class, 'newsletter'])->name('newsletter.subscribe');
Route::group(['controller' => CallbackController::class, 'prefix' => 'callback', 'as' => 'callback.'], function () {
    Route::get('/payment/{paymentId}/{order}/success', 'paymentSuccess')->name('payment.success');
    Route::get('/payment/{paymentId}/{order}/cancel', 'paymentCanceled')->name('payment.cancel');
    Route::get('two/payment/{order}/success', 'twoPaymentSuccess')->name('two.payment.success');
    Route::get('elavon/payment/success', 'elavonPaymentSuccess')->name('elavon.payment.success');
    Route::get('elavon/payment/cancel/{order_id}', 'elavonPaymentCancel')->name('elavon.payment.cancel');
    Route::get('api/elavon/payment/success', 'elavonApiPaymentSuccess')->name('api.elavon.payment.success');
    Route::get('api/elavon/payment/cancel/{order_id}', 'elavonApiPaymentCancel')->name('api.elavon.payment.cancel');
    Route::get('subscription/{subscription}/success', 'subscriptionSuccess')->name('subscription.success');
    Route::get('subscription/{subscription}/cancel', 'subscriptionCancel')->name('subscription.cancel');
    Route::any('subscription-callback', 'subscriptionCallback')->name('subscription');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
Route::post('admin/shop/update/{shop}', [DashboardController::class, 'updateProfile'])->middleware('auth', 'role:admin')->name('admin.profile.update');

Route::get('/check-shipping', function (Request $request) {
    $request->validate([
        'shipping' => 'required'
    ]);
    if (auth()->check()) {
        return auth()->user()->checkIfShippingIsValid(Shipping::find($request->shipping)) ? 'true' : 'false';
    } else {
        return 'false';
    }
});

Route::get('subscription/test', function (Request $request) {})->name('subscription.test');

Route::get('{user_name}/current-currency/{symbol}', function ($user_name, $symbol) {

    session()->put('current_currency', [request()->user_name => $symbol]);

    return back();
})->name('set.currency');


Route::get('clear-sessions', function () {
    session()->flush();
    return redirect()->back();
})->name('clear.session');
Route::get('manager-updt', function () {
    $users = User::where('role_id', 3)->whereHas('shop')->whereNull('shop_id')->get();
    foreach ($users as $user) {
        $user->shop_id = $user->shop->id;
        $user->save();
    }
});

Route::get('/test', function () {
    $shops =  Shop::has('retailer')->whereHas('orders', function ($query) {
        $query->where('is_demo', false)->where('payment_status', 1)->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()]);
    })->get();
    // dd($shops);
    $sum = 0;
    $orders_list = [];
    $earnings = RetailerEarning::where('method', 'commission_from_sales')->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()])->delete();
    foreach ($shops as $shop) {
        $orders =  $shop->orders()->where('payment_status', 1)->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()])->get();
        foreach ($orders as $order) {
            RetailerCommission::commission_from_sales($order)->pay();
        }
    }
    // return $earnings;
    return $sum;
});


Route::get('/test/resolve', function () {

    $retailers = RetailerMeta::whereHas('user', function ($query) {
        $query->whereHas('earnings');
    })->get();
    $data = [];
    foreach ($retailers as $retailer) {

        $user = $retailer->user;


        $user->withdrawals()->create([
            'amount' => ($retailer->user->earnings()->where('created_at', '<', now()->startOfYear())->sum('amount') - $retailer->user->withdrawals()->where('created_at', '<', now()->startOfYear())->sum('amount')) / 100,
            'status' => 1,
            'created_at' => now()->subYear()->endOfYear()
        ]);

        $data[$retailer->user->name] = [
            'Before2024' => [
                'earning' =>  $retailer->user->earnings()->where('created_at', '<', now()->startOfYear())->sum('amount') / 100,
                'withdrawlas' =>  $retailer->user->withdrawals()->where('created_at', '<', now()->startOfYear())->sum('amount') / 100,
                'balance' => ($retailer->user->earnings()->where('created_at', '<', now()->startOfYear())->sum('amount') - $retailer->user->withdrawals()->where('created_at', '<', now()->startOfYear())->sum('amount')) / 100
            ],
            'On2024' => [
                'earning' =>  $retailer->user->earnings()->where('created_at', '>=', now()->startOfYear())->sum('amount') / 100,
                'withdrawlas' =>  $retailer->user->withdrawals()->where('created_at', '>=', now()->startOfYear())->sum('amount') / 100,
                'balance' =>  $retailer->user->totalBalance()
            ]
        ];
    }
    return $data;
});


Route::get('/test', function () {
    $shop = Shop::latest()->first();
    return new ShopInvoice($shop);
});

Route::get('view-payment-data/{type}/{id}', [PaymentController::class, 'viewPaymentData'])->name('view_payment_data')->middleware(['auth', 'role:external,vendor,enterprise', 'protectedLink']);

Route::get('/test-elavon', function () {
    $shop = Shop::latest()->first();
    return view('pdf.elavon_payment_shop_details', compact('shop'));
});



Route::get('/enterprise-onboarding-register', function () {
    return view('auth.enterpriseOnboarding');
})->name('enterpriseonboarding.register');

Route::post('/enterprise-onboarding-register', function (Request $request) {
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],

        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'phone' => ['required', 'string', 'max:255'],

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
            'role_id' => Role::where('name', 'enterprise')->first()->id,
        ]);
        $enterprise = EnterpriseOnboarding::create([
            'user_id' => $user->id,
            'key' => uniqid(),
            // 'company_name' => $request->company_name,
            // 'company_email' => $request->company_email,
            // 'company_address' => $request->company_address,
            // 'company_registration' => $request->company_reg,
            // 'company_domain' => $request->company_domain,
            'fee' => 299,
            'establishment_fee' => 0
        ]);

        // $subscription_fee = $enterprise->getSubscriptionFee();
        // $subscribe = (new Subscribe())->subscription();

        // $subscribe = $subscribe->getUrl($subscription_fee, false, [
        //     'continueurl' => route('enterprise.subscription.success', $subscribe->subscription->id),
        //     'cancelurl' => route('enterprise.subscription.cancel', $subscribe->subscription->id)
        // ]);

        // $subscription = $enterprise->subscription()->create([
        //     'key' => $subscribe['data']['payment_id'],
        //     'url' => $subscribe['data']['url'],
        //     'fee' => $subscription_fee
        // ]);

        DB::commit();
        Auth::login($user);
        return redirect()->route('enterprise.dashboard');
    } catch (Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors($e->getMessage());
    } catch (Error $e) {
        DB::rollBack();
        return redirect()->back()->withErrors($e->getMessage());
    }
})->name('enterpriseonboarding.register.post');

Route::get('test', function () {
    $shop = Shop::where('monthly_cost', '>', '0')->first();

    $data = "<p>Dear %s,</p>
            <p>We hope this message finds you well. This is a friendly reminder that your subscription fee <strong>%s</strong> for Shop will be charged on the <strong>%s</strong>.</p>
            <p>To ensure uninterrupted access to our services, please ensure that your card balance is sufficient to cover the subscription charge. If you need to update your payment information, you can do so by logging into your account and navigating to the billing section.</p>
            <p>We appreciate your continued support and look forward to serving you.</p>
            <br>
             <p>Best regards,</p>
            <p>%s <br> %s <br> %s</p>
        ";

    $mail_data = [
        'subject' => 'Upcoming Subscription Charge Notice',
        'body' => sprintf($data, $shop->user->full_name, Iziibuy::price($shop->subscriptionFeeFull()), now()->addMonth(1)->startOfMonth()->format('d M,Y'), $shop->user->full_name, $shop->company_name, $shop->contact_email),
        'button_link' => route('shop.charges.index'),
        'button_text' => 'Go to billing section',
        'emails' => [],
    ];
    return new NotificationEmail($mail_data);
});

Route::get('/order-confirmed', function () {

    $order = Order::where('payment_status', 1)->latest()->first();

    $mail =  new OrderConfirmed($order, 'Order has been confirmed', false);
    $mail2 =   new OrderDelivered($order, 'Order has been confirmed', true);

    Mail::to('reovilsayed@gmail.com')->send($mail);
    Mail::to('reovilsayed@gmail.com')->later(now()->addMinutes(1), $mail2);
});


Route::get('/test/payment', function () {

    return view('testpayment');
});
