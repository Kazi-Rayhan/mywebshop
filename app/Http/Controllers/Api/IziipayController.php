<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ExternalOrder;
use App\Models\PaymentMethodAccess;
use App\Payment\Elavon\ApiElavonPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class IziipayController extends Controller
{
    public function createPayment(PaymentMethodAccess $paymentMethodAccess, Request $request)
    {

        $api = $paymentMethodAccess->paymentapis()->where('key', $request->source_key)->first();


        $order =  ExternalOrder::create([
            'uuid' => Str::ulid(),
            'payment_method_access_id' => $paymentMethodAccess->id,
            'api_id' => $api->id,
            'customer_name' => $request->name,
            'customer_email' => $request->email,
            'customer_phone' => $request->phone,
            'customer_country' => $request->country,
            'customer_address' => $request->address,
            'customer_post_code' => $request->post_code,
            'taxValue' => $request->taxValue,
            'taxTotal' => $request->taxTotal,
            'orderId' => $request->orderId,
            'description' => $request->description,
            'source_url' => $api->domain,
            'success_redirect_url' => $api->success_redirect_url,
            'failed_redirect_url' => $api->failed_redirect_url,
            'amount' => $request->amount,
            'currency' => $request->currency,
        ]);

        $payment = (new ApiElavonPayment($order))->getPaymentLink();

        $order->update([
            'payment_id'=> $payment['data']['payment_id'],
            'payment_url'=>$payment['data']['url']
        ]);
        return response()->json([
            'url' => $order->payment_url
        ]);
    }
}
