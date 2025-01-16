<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\Shop;
use App\Models\Box;
use App\Payment\UserSubscription;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BoxesController extends Controller
{
    public function subscriptionBoxes($user_name)
    {
        $shop = Shop::where('user_name', $user_name)->with('boxes')->first();
        $boxes = $shop->boxes;
        return view('shop.subscription-box.subscription-boxes', compact('boxes'));
    }
    public function subscriptionBox($user_name, Box $box)
    {
        $product = $box->load('products');
        return view('shop.subscription-box.subscription-box', compact('product'));
    }

    public function subscriptionBoxSubscribe($user_name, Box $box)
    {
        define("RUNNING", 1);
        define("CANCELD", 0);

        $membership = $box->memberships()->where('user_id', auth()->id())->first();
        $box->loadCount('products');

        if ($membership && $membership->payment_url) {
            if ($membership->status == RUNNING) return redirect()->route('user.dashboard', $user_name)->withSuccess('Active Subscription');
            if ($membership->status == CANCELD) return redirect($membership->payment_url);
        }
        return view('shop.subscription-box.subscription-box-checkout', compact('box'));
    }
    public function startSubscription($user_name, Box $box, Request $request)
    {


        $request->validate([
            "first_name" => "required|string",
            "last_name" => "required|string",
            "email" => "required|email",
            "phone" => "required|numeric",
            "address" => "required|string",
            "city" => "required|string",
            "postal_code" => "required|string",
            "state" => "required|string",
        ]);

        try {
            DB::beginTransaction();
            $shop = Shop::where('user_name', $user_name)->firstOrFail();
            auth()->user()->createMetas([
                'address' => $request->address,
                'city' => $request->city,
                'post_code' => $request->postal_code,
                'state' => $request->state,
            ]);
            $membership = Membership::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'state' => $request->state,
                'shop_id' => $shop->id,
                'user_id' => auth()->id(),
                'box_id' => $box->id,
                'status' => 0,
            ]);
            DB::commit();
            $quickPay = new UserSubscription($shop);
            $subscription = $quickPay->subscribe($membership);
            
            if ($subscription === 200) {
                return redirect($membership->payment_url);
            }
            return redirect()->route('subscription-boxes', $request->user_name)->withErrors('Something went wrong');
        } catch (Exception $e) {
            return redirect()->route('subscription-boxes', $request->user_name)->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->route('subscription-boxes', $request->user_name)->withErrors($e->getMessage());
        }
    }

    public function subscriptionInvoice($user_name, Membership $membership)
    {
        $order = $membership;
        return view('shop.subscription-box.invoice', compact('order'));
    }
}
