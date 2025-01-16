<?php

namespace App\Http\Controllers\Dashboard\Shop;

use App\Constants\Constants;
use App\Http\Controllers\Controller;

use App\Models\Packageoption;
use Illuminate\Http\Request;

class PackageoptionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = Packageoption::where('shop_id', auth()->user()->shop->id)->paginate(10);
        return view('dashboard.shop.package-options.index', compact('options'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packageoption = new Packageoption();
        return view('dashboard.shop.package-options.create', compact('packageoption'));
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
            'title.*' => 'required|string',
            'minutes' => 'required|integer',
            'buffer' => 'required|integer',
            'details.*' => 'required|string'
        ]);
        $package = new Packageoption();
        $package->title = $request->title[config('voyager.multilingual.default')];
        $package->minutes = $request->minutes;
        $package->buffer = $request->buffer;
        $package->details = $request->details[config('voyager.multilingual.default')];
        $package->shop_id = auth()->user()->shop->id;
        $package->save();

        foreach (Constants::LANGUAGES['list'] as $language) {

            if ($language != config('voyager.multilingual.default')) {
                $newPackage = clone $package;
                $newPackage = $newPackage->translate($language);
                $newPackage->title = $request->title[$language];
                $newPackage->details = $request->details[$language];
                $newPackage->save();
            }
        }

        // $data['shop_id'] = auth()->user()->shop->id;

        // $packageOption = Packageoption::create($data);

        if ($request->default_option == '1' || Packageoption::where('shop_id', auth()->user()->shop->id)->count() < 2) {
            auth()->user()->shop->createMeta('default_package_option', $package->id);
        }
        return redirect()->route('shop.packageoptions.index')->with('success', 'Package option Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Packageoption  $packageoption
     * @return \Illuminate\Http\Response
     */
    public function show(Packageoption $packageoption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Packageoption  $packageoption
     * @return \Illuminate\Http\Response
     */
    public function edit(Packageoption $packageoption)
    {
        return view('dashboard.shop.package-options.edit', compact('packageoption'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Packageoption  $packageoption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Packageoption $packageoption)
    {
        $data = $request->validate([
            'title.*' => 'required|string',
            'minutes' => 'required|integer',
            'details.*' => 'required|string',
            'buffer' => 'required|numeric|gte:0',
        ]);
        $packageoption->title = $request->title[config('voyager.multilingual.default')];
        $packageoption->minutes = $request->minutes;
        $packageoption->buffer = $request->buffer;
        $packageoption->details = $request->details[config('voyager.multilingual.default')];
        $packageoption->shop_id = auth()->user()->shop->id;
        $packageoption->update();
        // $packageoption->update($data);
        foreach (Constants::LANGUAGES['list'] as $language) {

            if ($language != config('voyager.multilingual.default')) {

                $newPackageoption = $packageoption->translate($language);
                $newPackageoption->title = $request->title[$language];
                $newPackageoption->details = $request->details[$language];
                $newPackageoption->save();
            }
        }


        if ($request->default_option == '1' || Packageoption::where('shop_id', auth()->user()->shop->id)->count() <= 0) {
            auth()->user()->shop->createMeta('default_package_option', $packageoption->id);
        }
        if ($request->default_option == '0') {
            auth()->user()->shop->createMeta('default_package_option', null);
        }

        return redirect()->route('shop.packageoptions.index')->with('success', 'Package option updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Packageoption  $packageoption
     * @return \Illuminate\Http\Response
     */
    public function destroy(Packageoption $packageoption)
    {
        $shopId = auth()->user()->shop->id;
        $packageOptionsCount = Packageoption::where('shop_id', $shopId)->count();

        if ($packageOptionsCount > 1) {
            $packageoption->delete();
            $option = Packageoption::where('shop_id', $shopId)->first();
            auth()->user()->shop->createMeta('default_package_option', $option->id);
            $message = 'Package option Deleted';
        } else {
            $message = 'Minimum 1 package option is required';
        }

        return redirect()->route('shop.packageoptions.index')->with('success', $message);
    }
}
