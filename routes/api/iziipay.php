<?php

use App\Http\Controllers\Api\IziipayController;
use Illuminate\Support\Facades\Route;

Route::get('test', function () {
    return response()->json('asd');
});

Route::post('create-payment/{paymentMethodAccess:key}', [IziipayController::class, 'createPayment'])->name('iziipay.createPayment');
