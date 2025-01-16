<?php

use App\Http\Controllers\Dashboard\Manager\AvailabilityController;
use App\Http\Controllers\Dashboard\Manager\BookingController;
use App\Http\Controllers\Dashboard\Manager\BreakController;
use App\Http\Controllers\Dashboard\Manager\ClientController;
use App\Http\Controllers\Dashboard\Manager\DashboardController;
use App\Http\Controllers\Dashboard\Manager\OrdersController;
use App\Http\Controllers\Dashboard\Shop\PaymentController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {

//     dd(auth()->user());
// })->name('dashboard');
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/products', [DashboardController::class, 'products'])->name('products')->middleware('permission:product,browse');

Route::get('availability', [AvailabilityController::class, 'create'])->name('availability.create');
Route::get('availability/{day}/break', [BreakController::class, 'index'])
    ->name('availability.break.index');
Route::post('availability', [AvailabilityController::class, 'store'])->name('availability.store');
Route::post('availability/scheduled', [AvailabilityController::class, 'scheduled'])->name('availability.scheduled');
Route::post('availability/break', [BreakController::class, 'storeUpdate'])
    ->name('availability.break.storeUpdate');
Route::delete('availability/{schedule}/break', [BreakController::class, 'destroy'])->name('availability.break.delete');
Route::post('availability/delete/{schedule}', [AvailabilityController::class, 'availabilityDestroy'])->name('availability.delete');

Route::get('bookings', [BookingController::class, 'index'])->name('booking.index')->middleware(['canProvideService'])->middleware('permission:booking,browse');
Route::post('bookings/bulk', [BookingController::class, 'bulk'])->name('booking.bulk')->middleware(['canProvideService'])->middleware('permission:booking,browse');
Route::post('booking/{booking}/note', [BookingController::class, 'createNote'])->name('booking.note')->middleware(['canProvideService']);
Route::get('bookings/callender', [BookingController::class, 'myCalender'])->name('booking.callender')->middleware(['canProvideService']);
Route::get('bookings/getevents', [BookingController::class, 'getEvents'])->name('booking.getEvents')->middleware(['canProvideService']);

Route::get(
    'booking/{booking}/set-status/completed',
    [BookingController::class, 'booking_complete']
)->name('booking.status.completed')->middleware(['canProvideService']);

Route::get(
    'booking/{booking}/set-status/cancel',
    [
        BookingController::class, 'booking_cancel'
    ]
)->name('booking.status.cancel')->middleware(['canProvideService']);

Route::middleware('isPersonalTrainer')->group(
    function () {
        Route::get('/{user}/{option}/booking-confirm',  [BookingController::class, 'confirm_booking'])->name('confirm_booking');
        // Route::get('cancel-booking/{booking}',  [PersonalTrainersController::class, 'cancel'])->name('cancel.booking')->middleware('auth');

        Route::get('/clients', [ClientController::class, 'index'])->name('booking.client.index')->middleware('permission:personal_trainee,browse');
        Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create')->middleware('permission:personal_trainee,create');
        Route::post('/clients/store', [ClientController::class, 'store'])->name('booking.client.store');

        Route::get('/{user}/{option}/booking', [BookingController::class, 'booking_show'])->name('booking.book');
        Route::get('/{user}/services', [BookingController::class, 'service_index'])->name('booking.services');
        Route::post('/{user}/services', [BookingController::class, 'service_book'])->name('booking.services.post');

        Route::middleware('personalClient')->group(
            function () {
                Route::get('/clients/{user}/edit', [ClientController::class, 'edit'])->name('booking.client.edit')->middleware('permission:personal_trainee,edit');
                Route::put('/clients/{user}/update', [ClientController::class, 'update'])->name('booking.client.update');
                Route::delete('/clients/{user}/delete', [ClientController::class, 'delete'])->name('booking.client.delete');
                Route::get('/clients/addSessions', [ClientController::class, 'addSessions'])->name('booking.client.addSessions')->middleware('permission:personal_trainee,edit');
            }
        );
        Route::post('/clients/store', [ClientController::class, 'store'])->name('client.store');
        Route::get('commissions', [DashboardController::class, 'commissions'])->name('commisssions.index');
    }
);
Route::get('report', [DashboardController::class, 'report'])->name('report');


Route::get('orders', [OrdersController::class, 'index'])->name('order.index');
Route::get('/invoice/{order}', [OrdersController::class, 'invoice'])->name('invoice');
Route::get('/invoice/{order}/pdf', [OrdersController::class, 'download'])->name('invoice.download');
    
Route::get('/orders/{order}/fulfilled', [PaymentController::class, 'orderFulfilled'])->name('orders.fulfiled');
Route::get('/orders/{order}/cancel', [PaymentController::class, 'orderCancel'])->name('orders.cancel');
Route::get('/orders/{order}/refund', [PaymentController::class, 'refundView'])->name('orders.refund');
Route::post('/orders/{order}/refund-store', [PaymentController::class, 'refund'])->name('orders.refund.store');
Route::post('/order/{order}/capture', [PaymentController::class, 'captureOrder'])->name('captureOrder');
