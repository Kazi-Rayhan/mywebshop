<?php

use App\Http\Controllers\Dashboard\User\DashboardController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;


Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
Route::get('/', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('/booking', [DashboardController::class, 'booking'])->name('booking');
Route::get('/order', [DashboardController::class, 'orders'])->name('orders');
Route::get('/membership', [DashboardController::class, 'memberships'])->name('memberships');

Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
Route::get('/order', [DashboardController::class, 'orders'])->name('orders');
Route::get('/personal-trainer', [DashboardController::class, 'ptTrainer'])->name('pt_trainer');
Route::post('/user-update', [DashboardController::class, 'update'])->name('update');
Route::get('/password-change', [DashboardController::class, 'passwordchange'])->name('passwordchange');
Route::post('/password-change', [DashboardController::class, 'changepassword'])->name('password.change');

Route::get('booking/{booking}', [DashboardController::class, 'bookingShow'])->name('bookingsingle');
Route::get('invoice/{order}', [DashboardController::class, 'invoice'])->name('invoice');
Route::get('{credit}/renew',  [DashboardController::class,'renew'])->name('renew');
Route::get('chat/{user}', [DashboardController::class, 'chat'])->name('chat');
