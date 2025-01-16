<?php

namespace App\Http\Controllers;

use App\Models\ExternalOrder;
use App\Models\PaymentApi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ButtonPaymentController extends Controller
{
    public function index()
    {
        $paymentMethodAccess = auth()->user()->paymentMethodAccess;
        $apis = PaymentApi::where('payment_method_access_id', $paymentMethodAccess->id)->get();

        return view('dashboard.external.button.index', compact('apis'));
    }


    public function edit(PaymentApi $paymentApi)
    {


        if($paymentApi->payment_method_access_id != auth()->user()->paymentMethodAccess->id) abort(403);
        return view('dashboard.external.button.edit', compact('paymentApi'));
    }
    public function create()
    {
        return view('dashboard.external.button.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'success' => 'required',
            'failed' => 'required',
            'domain' => 'required',
        ]);

        PaymentApi::create([
            'status' => 1,
            'payment_method_access_id' => auth()->user()->paymentMethodAccess->id,
            'key' => Str::ulid(),
            'domain' => $request->domain,
            'success_redirect_url' => $request->success,
            'failed_redirect_url' => $request->failed,
        ]);
        
        return redirect()->route('external.buttonPayment')->with('success', 'Payment api created');
    }


    public function update(PaymentApi $paymentApi, Request $request)
    {

     
        if($paymentApi->payment_method_access_id != auth()->user()->paymentMethodAccess->id) abort(403);
        $request->validate([
            'success' => 'required',
            'failed' => 'required',
            'domain' => 'required',
        ]);

        $paymentApi->update([
            'domain' => $request->domain,
            'success_redirect_url' => $request->success,
            'failed_redirect_url' => $request->failed,
        ]);
        return redirect()->route('external.buttonPayment')->with('success', 'Payment api updated');
    }

    public function view(PaymentApi $paymentApi)
    {
        if($paymentApi->payment_method_access_id != auth()->user()->paymentMethodAccess->id) abort(403);
        $orders = ExternalOrder::where('api_id', $paymentApi->id)->paginate(20);
        $paymentMethodAccess = auth()->user()->paymentMethodAccess;
        return view('dashboard.external.button.view', compact('paymentApi', 'paymentMethodAccess', 'orders'));
    }
}
