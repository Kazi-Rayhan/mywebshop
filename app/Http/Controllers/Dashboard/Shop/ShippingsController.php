<?php

namespace App\Http\Controllers\Dashboard\Shop;

use App\Http\Controllers\Controller;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShippingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shop = Auth::user()->shop;

        $shippings = Shipping::where('shop_id', $shop->id)->get();
        
        return view('dashboard.shop.shippings.index', compact('shippings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shipping = new Shipping;

        return view('dashboard.shop.shippings.create', compact('shipping'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'method' => 'required|string',
            'locations' => 'required',
            'cost' => 'required|integer'
        ]);
        $shop = Auth::user()->shop;

        Shipping::create([             
            'shop_id' => $shop->id,
            'shipping_method' => $request->method,
            'shipping_cost' => $request->cost,
            'locations' => json_encode($request->locations),
        ]);
   
        return redirect()->route('shop.shippings.index')->withSuccess('Shipping method created');
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
    public function edit(Shipping $shipping)
    {
        $shop = Auth::user()->shop;
        if ($shipping->shop_id != $shop->id) abort(403);
        return view('dashboard.shop.shippings.edit', compact('shipping'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shipping $shipping)
    {
        $shop = Auth::user()->shop;
        if ($shipping->shop_id != $shop->id) abort(403);
        $request->validate([
            'method' => 'required|string',
            'locations' => 'required',
            'cost' => 'required'
        ]);
        $shop = Auth::user()->shop;
        $shipping->update([
            'shop_id' => $shop->id,
            'shipping_method' => $request->method,
            'shipping_cost' => $request->cost,
            'locations' => json_encode($request->locations),
        ]);
        return redirect()->route('shop.shippings.index')->withSuccess('Shipping method created');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shipping $shipping)
    {
        $shipping->delete();
        return redirect()->back()->withSuccess('Shipping method deleted');
    }

    public function updateConfig(Request $request)
    {
        $request->validate([
            'toggle' => 'required'
        ]);

        auth()->user()->shop()->update([
            'store_as_pickup_point' => $request->toggle
        ]);

        return redirect()->back()->with(['success', 'Successfull']);
    }

}
