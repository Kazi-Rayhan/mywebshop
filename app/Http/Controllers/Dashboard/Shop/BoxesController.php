<?php

namespace App\Http\Controllers\Dashboard\Shop;

use App\Models\Box;
use App\Models\Membership;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class BoxesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $boxes = Auth::user()->shop->boxes;
        $boxes = $boxes->loadCount('products');
        return view('dashboard.shop.boxes.index', [
            'boxes' => $boxes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $box = new Box;
        $shop = Auth::user()->shop;
        $shop = $shop->load('products');
        return view('dashboard.shop.boxes.create', [
            'shop' => $shop,
            'box' => $box
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

        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'duration_mode' => 'required',
            'duration_length' => 'required',
            'image' => 'nullable|image',
            'price' => 'required',
            'est_cost' => 'nullable|integer',
            'products' => 'required|array|min:1'

        ]);
        try {

            DB::beginTransaction();
            $box =  Box::create([
                'shop_id' => Auth::user()->shop->id,
                'title' => $request->title,
                'duration' => json_encode(['mode' => $request->duration_mode, 'length' => $request->duration_length]),
                'description' => $request->description,
                'image' => $request->has('image') ? $request->image->store('box') : null,
                'price' => $request->price,
                'est_cost' => $request->est_cost,

            ]);

            $box->products()->attach($request->products);
            DB::commit();
            return redirect()->route('shop.boxes.index')->withSuccess('New Subscription Box Added');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Box $box)
    {
        $box = $box->load('memberships');
        return view('dashboard.shop.boxes.show', [
            'box' => $box
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Box $box)
    {
        $shop = Auth::user()->shop;
        $shop = $shop->load('products');
        return view('dashboard.shop.boxes.edit', [
            'shop' => $shop,
            'box' => $box
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Box $box)
    {

        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'duration_mode' => 'required',
            'duration_length' => 'required',
            'est_cost' => 'required',
            'image' => 'nullable|mimes:jpg,jpeg,png',
            'price' => 'required',
            'products' => 'required|array|min:1|exists:products,id'
        ]);
        try {
            DB::beginTransaction();
            $box->update([
                'title' => $request->title,
                'duration' => json_encode(['mode' => $request->duration_mode, 'length' => $request->duration_length]),
                'description' => $request->description,
                'price' => $request->price,
                'est_cost' => $request->est_cost,
            ]);
            if ($request->has('image')) {
                if ($box->image && Storage::exists($box->image)) {
                    Storage::delete($box->image);
                }

                $box->image = $request->image->store('box');
                $box->save();
            }

            DB::commit();

            $box->products()->sync($request->products);
            return redirect()->route('shop.boxes.index')->withSuccess('Subscription Box Upadted');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Box $box)
    {
        try {
            DB::beginTransaction();
            $box->products()->detach();
            $box->delete();
            DB::commit();
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        } catch (Error $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function subscriptionInvoice(Membership $membership)
    {

        return view('dashboard.shop.boxes.invoice', [
            'order' => $membership,
        ]);
    }
}
