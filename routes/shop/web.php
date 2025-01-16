<?php

use App\Http\Controllers\CallbackController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\Dashboard\Shop\BookingController;
use App\Http\Controllers\Dashboard\User\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Shop\BoxesController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\Shop\PagesController;
use App\Http\Controllers\Shop\PersonalTrainersController;
use App\Models\Order;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'shop/{user_name}', 'middleware' => 'shopCheck'], function () {

    Route::get('/', [PagesController::class, 'index'])->name('shop.home');
    Route::get('/products', [PagesController::class, 'products'])->name('products');
    Route::get('/scan-code', [PagesController::class, 'scan'])->name('shop.scan');

    Route::get('/product/{product:slug}', [PagesController::class, 'product'])->name('product');
    Route::group(['prefix' => 'cuppon'], function () {
        Route::post('/apply', [CouponController::class, 'add'])->name('coupon');
        Route::get('/remove', [CouponController::class, 'destroy'])->name('coupon.destroy');
    });
    Route::group(['prefix' => 'cart'], function () {
        Route::any('/store', [CartController::class, 'add'])->name('cart.store');
        Route::any('scanner-cart-store', [CartController::class, 'scanner_cart_store'])->name('scanner.cart.store');
        Route::get('/add/{product}', [CartController::class, 'orderProduct'])->name('order.product');
        Route::post('/update', [CartController::class, 'update'])->name('cart.update');
        Route::get('/destroy/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    });

    Route::get('checkout', [CheckoutController::class, 'checkout'])->name('checkout');

    Route::get('payment/{order}', [CheckoutController::class, 'payment'])->name('payment');
    Route::post('two/checkout/store', [CheckoutController::class, 'two_checkout'])->name('two.checkout.store');
    Route::any('checkout/store', [CheckoutController::class, 'checkoutStore'])->name('checkout.store');

    Route::get('trainers-list', [PersonalTrainersController::class, 'list'])->name('trainers.list');
    Route::get('trainers/{trainer?}', [PersonalTrainersController::class, 'trainers'])->name('trainer.index');
    Route::post('trainers/book', [PersonalTrainersController::class, 'bookTrainer'])->name('trainer.book');


    Route::get('thankyou', [HomeController::class, 'thankyou'])->name('thankyou');
    Route::get('services/{user}/{option}/schedule', [DashboardController::class, 'trainerServicesSchedule'])->name('trainer_services.schedule');
    Route::get('confirm-booking/trainer/{user}/{option}',  [PersonalTrainersController::class, 'storeTrainer'])->middleware('auth');
    Route::get('confirm-free-appointment-booking',  [PersonalTrainersController::class, 'freeBooking'])->name('trainer-free-booking')->middleware('auth');
    Route::get('cancel-booking/{booking}',  [PersonalTrainersController::class, 'cancel'])->name('cancel.booking')->middleware('auth');


    Route::get('order/{product}', [CheckoutController::class, 'directOrder'])->name('direct-order');
    Route::get('order/cancel/{order}', [CheckoutController::class, 'orderCancel'])->name('order.cancel');
    Route::get('create-qr-callback/{order}', [CheckoutController::class, 'qrCallback'])->name('callback-qr');

    Route::post('/active/selfcheckout',  [PagesController::class, 'active_kiosk'])->name('active.selfcheckout');

    Route::get('services', [PagesController::class, 'services'])->name('services');
    Route::get('booking/{booking}', [PagesController::class, 'booking'])->name('booking');
    Route::get('services/{service:slug}', [PagesController::class, 'serviceSingle'])->name('serviceSingle');
    Route::get('time-slot/{service:slug}/{manager}', [PagesController::class, 'timeSlot'])->name('timeSlot');
    Route::get('confirm-booking/{service:slug}/{manager}', [BookingController::class, 'show'])
        ->middleware(['auth'])
        ->name('service.checkout');
    Route::post('confirm-booking/{service:slug}/{manager}', [BookingController::class, 'store'])
        ->middleware(['auth']);
    Route::get('booking/{booking}', [BookingController::class, 'booking'])->middleware('auth')->name('booking-placed');
    Route::get('service/pay/{booking}', [BookingController::class, 'pay'])->name('booking.pay')->middleware(['auth']);
    Route::get('booking/confirm-payment/{paymentid}/{shop}', [BookingController::class, 'confirmPayment'])->name('confirmPayment.booking')->middleware(['auth']);

    Route::get('confirm-user-subscription/{subscription_id}', [CallbackController::class, 'confirmUserSubscription'])->middleware('auth')->name('confirm.userSubscription');
    Route::group(['prefix' => 'subscription'], function () {

        Route::get('boxes', [BoxesController::class, 'subscriptionBoxes'])->name('subscription-boxes');
        Route::get('boxes/{box}', [BoxesController::class, 'subscriptionBox'])->name('subscription-box');

        Route::middleware('auth')->group(function () {
            Route::get('{membership}/invoice', [BoxesController::class, 'subscriptionInvoice'])->name('subscription.invoice');
            Route::get('box/{box}/subscribe', [BoxesController::class, 'subscriptionBoxSubscribe'])->name('subscription-box-subscribe');
            Route::post('box/{box}/subscribe', [BoxesController::class, 'startSubscription'])->name('subscription-box-start-subscription');
        });
    });
});
