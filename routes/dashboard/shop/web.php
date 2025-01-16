<?php

use App\Http\Controllers\Dashboard\Shop\{
    BookingController,
    BoxesController,
    DashboardController,
    ProductsController,
    CategoriesController,
    ClientController,
    ShippingsController,
    SlidersController,
    LevelController,
    PackageoptionController,
    StoreController,
    ManagersController,
    CouponController,
    ManagerScheduleController,
    PaymentController,
    PriceGroupController,
    RegisterController,
    ReportController,
    ResourcesController,
    ServicesController,
};
use App\Http\Controllers\QrcodeController;
use App\Models\Booking;
use Illuminate\Support\Facades\Route;


Route::post('remove-media', [DashboardController::class, 'removeMedia'])->name('remove.media');


Route::get('/complete-registration', [RegisterController::class, 'completeProfile'])->name('completeProfile');

Route::put('/complete-registration', [RegisterController::class, 'completeProfileUpdate'])->name('profile.completeProfileUpdate');
Route::get('subscription', [RegisterController::class, 'subscriptionIndex'])->name('subscription.payment');
Route::get('delete-account', [RegisterController::class, 'deleteAccount'])->name('delete.account');
Route::any('enroll-subscription', [RegisterController::class, 'enrollSubscription'])->name('enroll.subscription');
Route::get('confirm-subscription/{subscription_id}', [RegisterController::class, 'confirmSubscription'])->name('confirm.subscription');

Route::get('/charges', [DashboardController::class, 'indexCharges'])->name('charges.index');
Route::get('/charges/{charge}/invoice', [DashboardController::class, 'chargesInvoice'])->name('charge.invoice');
Route::get('/charges/{charge}/invoice/pdf', [DashboardController::class, 'downloadInvoice'])->name('download.invoice');

Route::middleware('Paid')->group(function () {

    //Products Related Routes
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('qrcodes', QrcodeController::class);
    Route::resource('products', ProductsController::class)->except('show')->middleware('permission:product,browse');
    Route::group(['prefix' => 'products', 'controller' => ProductsController::class, 'as' => 'products.'], function () {
        Route::post('order', 'order')->name('order');
        Route::post('change-status', 'change_status')->name('change_status');
        Route::get('pin/{product}', 'pin')->name('pin');

        Route::group(['prefix' => 'attribute/', 'as' => 'attribute.'], function () {
            Route::post('store', 'store_attribue')->name('store');
            Route::post('update', 'update_attribue')->name('update');
            Route::get('{attribute}/delete', 'delete_attribue')->name('destroy');
        });

        Route::group(['prefix' => 'variation/{product}/', 'as' => 'variation.'], function () {
            Route::get('create', 'create_variation')->name('create');
            Route::get('affiliate', 'affiliate_variation')->name('affiliate');
            Route::post('update',  'update_variation')->name('update');
            Route::delete('delete', 'delete_variation')->name('destroy');
        });
    });

    Route::resource('categories', CategoriesController::class)->except('show')->middleware('permission:category,browse');
    Route::get('categories/order', [CategoriesController::class, 'order'])->name('categories.order');

    Route::resource('shippings', ShippingsController::class)->middleware('permission:shipping,browse');
    Route::post('update/config', [DashboardController::class, 'updateConfig'])->name('update.config');
    // store related route
    Route::group(['prefix' => 'settings',  'as' => 'store.'], function () {
        Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
        Route::post('profile', [DashboardController::class, 'updateProfile'])->name('profile.update');
    });
    Route::resource('sliders', SlidersController::class);

    Route::resource('levels', LevelController::class);
    Route::resource('packageoptions', PackageoptionController::class);

    Route::resource('coupon', CouponController::class);
    Route::resource('storage', StoreController::class)->middleware('permission:store,browse');
    Route::post('/storage/{store}/add-product', [StoreController::class, 'addProduct'])->name('add-product');
    //slider related route
    Route::resource('sliders', SlidersController::class)->except('create', 'show')->middleware('permission:slider,browse');
    //Shop langaue related route    
    Route::get('translations', [DashboardController::class, 'translations'])->name('translations');
    Route::get('shop-translations', [DashboardController::class, 'shop_translations'])->name('shop_translations');
    Route::post('shop-translations', [DashboardController::class, 'shop_translations_update'])->name('shop_translations_update');
    Route::post('languages/update', [DashboardController::class, 'update_languages'])->name('languages.update');
    Route::post('terms/update', [DashboardController::class, 'update_terms'])->name('terms.update');

    //End of shop langaue related route 

    Route::get('/managers', [ManagersController::class, 'index'])->name('managers')->middleware('permission:manager,browse');
    Route::get('/managers/{user}/schedule', [ManagersController::class, 'schedule'])->name('managers.schedule');
    Route::post('/managers/{user}/schedule/update', [ManagersController::class, 'updateSchedule'])->name('managers.schedule.update');
    Route::post('/managers/store', [ManagersController::class, 'store'])->name('managers.store');
    Route::delete('/managers/{user}/destroy', [ManagersController::class, 'delete'])->name('managers.delete');
    Route::put('/managers/{user}/update', [ManagersController::class, 'update'])->name('managers.update');
    Route::get('my-qr/{user}', [ManagersController::class, 'myQr'])->name('myQr');
    Route::resource('sliders', SlidersController::class)->middleware('permission:slider,browse');
    Route::post('/update/config', [DashboardController::class, 'updateConfig'])->name('update.config');
    Route::post('order/vcard', [ManagersController::class, 'orderVcard'])->name('order.vCard');
    //finance
    Route::resource('coupon', CouponController::class)->middleware('permission:slider,browse')->middleware('permission:coupon,browse');


  
    Route::get('/cancel-subscription', [DashboardController::class, 'cancelSubscription'])->name('cancel-subscription');

    Route::get('complete-signup', [PaymentController::class, 'completeSignup'])->name('complete.signup');
    Route::post('complete-signup', [PaymentController::class, 'postCompleteSignup'])->name('post.complete.signup');


    Route::get('/setup/payment/elavon', [PaymentController::class, 'setup_elavon_payment'])->name('setup_elavon_payment');
    Route::post('/setup/payment/elavon', [PaymentController::class, 'store_setup_elavon_payment'])->name('store_setup_elavon_payment');
    Route::get('/verify/payment/elavon', [PaymentController::class, 'verifyElavonPayment'])->name('verify_elavon_payment_information');
    Route::get('/setup/payment/two', [PaymentController::class, 'setup_payment_two'])->name('setup_payment_two');
    Route::post('/setup/payment/two', [PaymentController::class, 'store_setup_payment_two'])->name('store_setup_payment_two');

    Route::get('/service/subscription', [RegisterController::class, 'serviceSubscription'])->name('service.subscription');
    Route::get('/service/subscribe', [RegisterController::class, 'serviceSubscribe'])->name('service.subscribe');
    Route::get('/orders/{order}/fulfilled', [PaymentController::class, 'orderFulfilled'])->name('orders.fulfiled');
    Route::get('/orders/{order}/cancel', [PaymentController::class, 'orderCancel'])->name('orders.cancel');
    Route::get('/orders/{order}/refund', [PaymentController::class, 'refundView'])->name('orders.refund');
    Route::post('/orders/{order}/refund-store', [PaymentController::class, 'refund'])->name('orders.refund.store');
    Route::post('/order/{order}/capture', [PaymentController::class, 'captureOrder'])->name('captureOrder');

    //Subscription Box related routes
    // Route::resource('boxes', BoxesController::class);
    // boxes Controller start
    Route::get('box', [BoxesController::class, 'index'])->name('boxes.index')->middleware('permission:subscription_product,browse');
    Route::get('box/create', [BoxesController::class, 'create'])->name('boxes.create')->middleware('permission:subscription_product,create');
    Route::post('box/store', [BoxesController::class, 'store'])->name('boxes.store');
    Route::get('box/edit/{box}', [BoxesController::class, 'edit'])->name('boxes.edit')->middleware('permission:subscription_product,edit');
    Route::get('box/show/{box}', [BoxesController::class, 'show'])->name('boxes.show');
    Route::delete('box/destroy/{box}', [BoxesController::class, 'destroy'])->name('boxes.destroy')->middleware('permission:subscription_product,edit');
    Route::put('box/update/{box}', [BoxesController::class, 'update'])->name('boxes.update');
    // Boxes controller end
    Route::get('/boxes/subscription/{membership}/invoice', [BoxesController::class, 'subscriptionInvoice'])->name('subscriptionInvoice');
    //end of Subscription Box related routes




    Route::group(['as' => 'booking.', 'middleware' => ['canProvideService']], function () {

        Route::resource('services', ServicesController::class)->except('show');
        Route::resource('resources', ResourcesController::class);
        Route::resource('price-groups', PriceGroupController::class);
        Route::get('assign-group/create/{user}', [BookingController::class, 'assignGroupCreate'])->name('assignGroup.create');
        Route::post('manager/schedule-update/{user}', [BookingController::class, 'updateManagerSchedule'])->name('manager.updateManagerSchedule');
        Route::post('manager/{user}/price-group', [BookingController::class, 'updateStorePriceManager'])->name('manager.updatestoreprice');
        Route::get('booking/callender', [BookingController::class, 'myCalender'])->name('callender');
        Route::get('bookings', [BookingController::class, 'index'])->name('index');
        Route::get('clients', [ClientController::class, 'index'])->name('client.index')->middleware('permission:personal_trainee,browse');
        Route::middleware('personalClient')->group(
            function () {
                Route::get('/clients/addSessions', [ClientController::class, 'addSessions'])->name('client.addSessions')->middleware('permission:personal_trainee,edit');
            }
        );
        Route::get('booking/{booking}/set-status/completed', function (Booking $booking) {
            try {
                if ($booking->shop_id != auth()->user()->shop->id) throw new Exception("You do not have access");
                if ($booking->status != 'Pending') throw new Exception("Status can't be changed");
                $booking->update(['status' => $booking::STATUS_COMPLETED]);
                return redirect()->back()->with('success', 'Status updated to completed');
            } catch (Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            } catch (Error $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        })->name('status.completed');
    });
    Route::get('manager-schedule', [ManagerScheduleController::class, 'index'])->name('manage-schedule.index');
    Route::put('manager-schedule/{booking}', [ManagerScheduleController::class, 'update']);

    Route::get('disablekyc', function () {
        auth()->user()->shop->createMeta('needKYC', false);
        return redirect()->back();
    })->name('disablekyc');


    include 'tamim.php';
    include 'abdur.php';
});
