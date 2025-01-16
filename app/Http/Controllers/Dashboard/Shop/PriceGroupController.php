<?php

namespace App\Http\Controllers\Dashboard\Shop;

use App\Http\Controllers\Controller;
use App\Models\PriceGroup;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PriceGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = PriceGroup::where('shop_id', auth()->user()->shop->id)->paginate(10);
        return view('dashboard.shop.booking.groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.shop.booking.groups.create', [
            'priceGroup' => new PriceGroup()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate(['name' => 'required']);
        try {
            Auth::user()->shop->priceGroups()->create([
                'name' => $request->name
            ]);
            return redirect()->route('shop.booking.price-groups.index')->with('success', 'Group created successfully');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PriceGroup  $priceGroup
     * @return \Illuminate\Http\Response
     */
    public function show(PriceGroup $priceGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PriceGroup  $priceGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(PriceGroup $priceGroup)
    {
        return view('dashboard.shop.booking.groups.edit',compact('priceGroup'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PriceGroup  $priceGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PriceGroup $priceGroup)
    {
     
        $request->validate(['name' => 'required']);
        try {
           $priceGroup->update([
                'name' => $request->name
            ]);
            return redirect()->route('shop.booking.price-groups.index')->with('success', 'Group updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PriceGroup  $priceGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(PriceGroup $priceGroup)
    {
        try {
           $priceGroup->delete();
            return redirect()->route('shop.booking.price-groups.index')->with('success', 'Group deleted successfully');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
