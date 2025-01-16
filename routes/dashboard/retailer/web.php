<?php

use App\Http\Controllers\Dashboard\Retailer\RetailerController;
use App\Http\Controllers\Dashboard\Retailer\RetailerTicketController;
use Illuminate\Support\Facades\Route;


Route::get('/', [RetailerController::class, 'dashboard'])->name('dashboard');
Route::get('profile', [RetailerController::class, 'profile'])->name('profile');
Route::post('update-profile', [RetailerController::class, 'update_profile'])->name('update_profile');
Route::get('reports', [RetailerController::class, 'reports'])->name('reports');
Route::get('affiliates', [RetailerController::class, 'affiliates'])->name('affiliates');
Route::get('create-affiliates', [RetailerController::class, 'createAffiliates'])->name('createAffiliates');
Route::post('store-affiliates', [RetailerController::class, 'storeAffiliates'])->name('storeAffiliates');
Route::get('/log/earning', [RetailerController::class, 'logEarning'])->name('earning-log');
Route::get('withdrawals', [RetailerController::class, 'withdrawals'])->name('withdrawals');
Route::post('withdraw', [RetailerController::class, 'withdraw'])->name('withdraw');
Route::delete('/withdraw/delete/{withdrawal}', [RetailerController::class, 'withdrawalDestroy'])->name('withdrawal.destroy');
Route::resource('tickets', RetailerTicketController::class);
Route::post('ticket/reply/{ticket}', [RetailerTicketController::class, 'reply'])->name('ticket.reply');
Route::get('ticket/close/{ticket}', [RetailerTicketController::class, 'close'])->name('ticket.close');
