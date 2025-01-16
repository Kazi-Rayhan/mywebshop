<?php

use App\Http\Controllers\Dashboard\Shop\PackageController;
use App\Http\Controllers\Dashboard\Shop\TicketController;
use App\Mail\BookingPlaced;
use App\Mail\OrderConfirmed;
use App\Mail\OrderPlaced;
use App\Mail\TicketPlaced;
use App\Mail\WithdrawlMail;
use App\Models\Booking;
use App\Models\Order;
use App\Models\Ticket;
use Illuminate\Support\Facades\Route;


Route::resource('packages', PackageController::class);

Route::get('email/{order}', function (Order $order) {
    return new OrderConfirmed($order, 'This message is for test purpose');
});
Route::get('placed/{order}', function (Order $order) {
    return new OrderPlaced($order, 'This message is for test purpose');
});
Route::get('booking/{booking}/placed', function (Booking $booking) {
    return  new BookingPlaced($booking);
});
Route::get('ticket-email/{ticket}', function (Ticket $ticket) {
    return new TicketPlaced($ticket, 'This message is for test purpose');
});