<?php

namespace App\Http\Controllers;

use App\Models\Qrcode;
use Illuminate\Http\Request;

class QrcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $codes = Qrcode::where('shop_id', auth()->user()->getShop()->id)->paginate(20);

        return view('dashboard.shop.qrcodes.index', compact('codes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.shop.qrcodes.create');
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
            'code' => 'required|unique:qrcodes,group',
        ]);

        $qrcode = new Qrcode;
        $qrcode->shop_id = auth()->user()->getShop()->id;
        $qrcode->group = $request->code;
        $qrcode->save();

        return redirect()->route('shop.qrcodes.index')->with('success', 'Qrcode created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Qrcode  $qrcode
     * @return \Illuminate\Http\Response
     */
    public function show(Qrcode $qrcode)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Qrcode  $qrcode
     * @return \Illuminate\Http\Response
     */
    public function edit(Qrcode $qrcode)
    {
        return view('dashboard.shop.qrcodes.edit', compact('qrcode'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Qrcode  $qrcode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Qrcode $qrcode)
    {
        $request->validate([
            'code' => 'required|unique:qrcodes,group',
        ]);


        $qrcode->group = $request->code;
        $qrcode->shop_id = auth()->user()->getShop()->id;
        $qrcode->save();

        return redirect()->route('shop.qrcodes.index')->with('success', 'Qrcode created');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Qrcode  $qrcode
     * @return \Illuminate\Http\Response
     */
    public function destroy(Qrcode $qrcode)
    {
        if ($qrcode->shop_id != auth()->user()->getShop()->id) abort(403);
        $qrcode->delete();
        return redirect()->route('shop.qrcodes.index')->with('success', 'Qrcode deleted');
    }
}
