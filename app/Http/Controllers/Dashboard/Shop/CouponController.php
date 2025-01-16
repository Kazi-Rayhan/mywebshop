<?php

namespace App\Http\Controllers\Dashboard\Shop;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::where('shop_id', auth()->user()->shop_id)->get();
        return view('dashboard.shop.coupon.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.shop.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required',
            'discount' => 'required',
            'expire_at' => 'required',
            'limit' => 'required',
            'minimum_cart' => 'required',
        ]);

        $coupon = Coupon::create([
            "shop_id"       => auth()->user()->shop->id,
            "code"          => $request->code,
            "discount"      => $request->discount,
            "expire_at"      => $request->expire_at,
            "limit"         => $request->limit,
            "minimum_cart"  => $request->minimum_cart,
        ]);
        $coupon->save();
        return redirect()->back()->with('success', 'Coupon Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        if ($coupon->shop_id != auth()->user()->shop_id) return abort(403);
        return view('dashboard.shop.coupon.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $coupon = Coupon::find($id);
        if ($coupon->shop_id != auth()->user()->shop_id) return abort(403);
        $coupon->code = $request->input('code');
        $coupon->discount = $request->input('discount');
        $coupon->expire_at = $request->input('expire_at');
        $coupon->limit = $request->input('limit');
        $coupon->minimum_cart = $request->input('minimum_cart');
        $coupon->update();
        return redirect()->back()->with('success', 'Coupon updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        if ($coupon->shop_id != auth()->user()->shop_id) return abort(403);
        $coupon->delete();
        return redirect()->back()->with('success', 'Coupon deleted successfully');
    }
}
