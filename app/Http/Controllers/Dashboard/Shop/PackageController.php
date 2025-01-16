<?php

namespace App\Http\Controllers\Dashboard\Shop;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\Package;
use App\Models\Packageoption;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $package_option = Packageoption::where('shop_id', auth()->user()->shop->id)->count();
        $packages = Package::where('shop_id', auth()->user()->shop->id)->paginate(10);
        return view('dashboard.shop.package.index', compact('package_option', 'packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $package = new Package;
        $levels = Level::where('shop_id', auth()->user()->shop->id)->get();
        return view('dashboard.shop.package.create', compact('package', 'levels'));
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
            'title' => 'required|string',
            // 'price' => 'required|numeric',
            // 'tax' => 'required|numeric',
            'sessions' => 'required|integer',
            'validity' => 'required|integer',
            'details' => 'required|string',
            'levels' => 'required',
            'levels.*.price' => 'required',
            'type' => 'required'
        ]);

        $package = Package::create([
            'shop_id' => auth()->user()->shop->id,
            'title' => $request->title,
            'validity' => $request->validity,
            // 'price' => $request->price,
            // 'tax' => $request->tax,
            'sessions' => $request->sessions,
            'details' => $request->details,
            'type' => $request->type,
            'split' => $request->split,
        ]);
        $package->levels()->sync($request->levels);
        return redirect()->route('shop.packages.index')->with('success', 'Package Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function show(Package $package)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit(Package $package)
    {
        $levels = Level::where('shop_id', auth()->user()->shop->id)->get();
        return view('dashboard.shop.package.edit', compact('levels', 'package'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        $request->validate([
            'title' => 'required|string',
            // 'price' => 'required|numeric',
            // 'tax' => 'required|numeric',
            'sessions' => 'required||integer',
            'validity' => 'required||integer',
            'details' => 'required|string',
            'levels' => 'required',
            'levels.*.price' => 'required',
            'type' => 'required'
        ]);

        $package->update([
            'title' => $request->title,
            // 'price' => $request->price,
            // 'tax' => $request->tax,
            'validity' => $request->validity,
            'sessions' => $request->sessions,
            'details' => $request->details,
            'type' => $request->type,
            'split' => $request->split,
        ]);
        $package->levels()->sync($request->levels);
        return redirect()->route('shop.packages.index')->with('success', 'Package updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('shop.packages.index')->with('success', 'Package Deleted');
    }
}
