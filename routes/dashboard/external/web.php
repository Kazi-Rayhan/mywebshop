<?php

use App\Http\Controllers\ButtonPaymentController;
use App\Http\Controllers\Dashboard\External\DashboardController;
use App\Http\Controllers\Dashboard\External\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/complete-registration', [DashboardController::class, 'completeProfile'])->name('completeProfile');
Route::post('/complete-registration', [DashboardController::class, 'completeProfileStore'])->name('completeProfileStore');
Route::get('subscription/callback/{subscription}/success', [DashboardController::class, 'subscriptionSuccess'])->name('subscription.success');
Route::get('subscription/callback/{subscription}/cancel', [DashboardController::class, 'subscriptionCancel'])->name('subscription.cancel');
Route::get('/contraact', [DashboardController::class, 'contract'])->name('contract');
Route::post('payment-method-access/{paymentMethodAccess}/sign-contract', [DashboardController::class, 'signContract'])->name('paymentMethodAccess.signContract');

Route::middleware('ExternalPaid')->group(function () {
    Route::get('/', [DashboardController::class, 'paymentMethodAccess'])->name('dashboard');
    Route::get('/charges', [DashboardController::class, 'charges'])->name('charges');
    Route::get('/edit', [DashboardController::class, 'edit'])->name('edit');
    Route::post('/update', [DashboardController::class, 'update'])->name('update');

    // Route::get('payment-method-access/{paymentMethodAccess}', [DashboardController::class, 'paymentMethodAccess'])->name('paymentMethodAccess');
    Route::get('/charges/{charge}/invoice/pdf', [DashboardController::class, 'downloadInvoice'])->name('download.invoice');
    Route::get('subscription/{subscription}/cancel', [DashboardController::class, 'cancelSubscription'])->name('cancel-subscription');
    Route::get('subscription/{subscription}/start', [DashboardController::class, 'startSubscription'])->name('start-subscription');

    Route::resource('tickets', TicketController::class);
    Route::post('ticket/reply/{ticket}', [TicketController::class, 'reply'])->name('ticket.reply');
    Route::get('ticket/close/{ticket}', [TicketController::class, 'close'])->name('ticket.close');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::post('/settings-update', [DashboardController::class, 'settingsUpdate'])->name('settings.update');
    Route::post('/password-update', [DashboardController::class, 'passwordUpdate'])->name('password.update');

    Route::get('/button-payment', [ButtonPaymentController::class, 'index'])->name('buttonPayment');
    Route::get('/button-payment/view/{paymentApi}', [ButtonPaymentController::class, 'view'])->name('buttonPayment.view');
    Route::get('/button-payment/edit/{paymentApi}', [ButtonPaymentController::class, 'edit'])->name('buttonPayment.edit');
    Route::post('/button-payment/edit/{paymentApi}', [ButtonPaymentController::class, 'update'])->name('buttonPayment.update');
    Route::get('/button-payment/create', [ButtonPaymentController::class, 'create'])->name('buttonPayment.create');
    Route::post('/button-payment/store', [ButtonPaymentController::class, 'store'])->name('buttonPayment.store');

    Route::get('/setup/payment/elavon', [DashboardController::class, 'setup_elavon_payment'])->name('setup_elavon_payment');
    Route::post('/setup/payment/elavon', [DashboardController::class, 'store_setup_elavon_payment'])->name('store_setup_elavon_payment');
    Route::get('/verify/payment/elavon', [DashboardController::class, 'verifyElavonPayment'])->name('verify_elavon_payment_information');

    Route::get('disablekyc', function () {
        auth()->user()->paymentMethodAccess->createMeta('needKYC', false);
        return redirect()->back();
    })->name('disablekyc');

    Route::get('download/plugin', function () {
        return redirect('https://github.com/reovilsayed/payquick/archive/refs/heads/main.zip');
    })->name('download.plugin');
});
