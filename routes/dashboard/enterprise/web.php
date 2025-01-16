<?php

use App\Http\Controllers\Dashboard\Enterprise\DashboardController;
use App\Http\Controllers\Dashboard\Enterprise\TicketController;
use App\Models\EnterpriseOnboarding;
use App\Models\Subscription;
use App\Models\User;
use App\Payment\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use TCG\Voyager\Models\Role;
use Illuminate\Support\Str;




Route::get('/complete-registration', [DashboardController::class, 'completeProfile'])->name('completeProfile');
Route::post('/complete-registration', [DashboardController::class, 'completeProfileStore'])->name('completeProfileStore');
Route::get('subscription/callback/{subscription}/success', [DashboardController::class, 'subscriptionSuccess'])->name('subscription.success');
Route::get('subscription/callback/{subscription}/cancel', [DashboardController::class, 'subscriptionCancel'])->name('subscription.cancel');
Route::post('enterprise/{enterpriseOnboarding}/sign-contract', [DashboardController::class, 'signContract'])->name('signContract');

Route::middleware('EnterprisePaid')->group(function () {
    Route::get('/contraact', [DashboardController::class, 'contract'])->name('contract');
    Route::get('/', [DashboardController::class, 'enterprise'])->name('dashboard');
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


    Route::get('/setup/payment/elavon', [DashboardController::class, 'setup_elavon_payment'])->name('setup_elavon_payment');
    Route::post('/setup/payment/elavon', [DashboardController::class, 'store_setup_elavon_payment'])->name('store_setup_elavon_payment');
    Route::get('/verify/payment/elavon', [DashboardController::class, 'verifyElavonPayment'])->name('verify_elavon_payment_information');

    Route::get('disablekyc', function () {
        auth()->user()->enterpriseOnboarding->createMeta('needKYC', false);
        return redirect()->back();
    })->name('disablekyc');

    Route::get('download/plugin', function () {
        return redirect('https://github.com/reovilsayed/payquick/archive/refs/heads/main.zip');
    })->name('download.plugin');
});
?>
