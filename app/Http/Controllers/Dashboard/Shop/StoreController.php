<?php

namespace App\Http\Controllers\Dashboard\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\UpdateStoreRequest;
use App\Models\Shop;
use App\Models\Store;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $storages = Store::all();
        return view('dashboard.shop.storage.index', compact('storages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $storage = new Store;
        return view('dashboard.shop.storage.create', compact('storage'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStoreRequest  $request)
    {
      
        try {
            $data = [
                'shop_id' => auth()->user()->shop->id,
                'city' => $request->city,
                'state' => $request->state,
                'post_code' => $request->post_code,
                'address' => $request->address
            ];
            Store::create($data);
            return redirect()->route('shop.storage.index')->with('success', 'Store created successfully');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Store $storage)
    {
        $shop = auth()->user()->shop;
        $categories = $shop->categories()->select('id', 'name')->with('products:id,name')->get();
        $products = Shop::find(auth()->user()->shop->id)->productsFromBelongToMany;
        return view('dashboard.shop.storage.show', compact('storage', 'products', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $storage)
    {
        return view('dashboard.shop.storage.edit', compact('storage'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateStoreRequest $request, Store $storage)
    {
        try {
            $data = [
                'city' => $request->city,
                'state' => $request->state,
                'post_code' => $request->post_code,
                'address' => $request->address
            ];
            $storage->update($data);
            return redirect()->route('shop.storage.index')->with('success', 'Store updated successfully');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $storage)
    {
        try {
            $storage->delete();
            return redirect()->route('shop.storage.index')->with('success', 'Store deleted successfully');
        } catch (Exception $e) {
            return redirect()->route('shop.storage.index')->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->route('shop.storage.index')->withErrors($e->getMessage());
        }
    }

    public function addProduct(Request $request, Store $store)
    {


        try {
            DB::table('product_store')->where('store_id', $store->id)->whereNotIn('product_id', array_column($request->product ?? [], 'product_id'))->delete();
            if (count(array_column($request->product ?? [], 'product_id')) > 0) {
                foreach ($request->product as $product) {

                    $store->products()->syncWithPivotValues($product['product_id'], ['quantity' => $product['quantity']], false);
                }
            }
            return redirect()->route('shop.storage.show', $store)->with('success', 'Store updated');
        } catch (Exception $e) {
            return redirect()->route('shop.storage.show', $store)->withErrors($e->getMessage());
        } catch (Error $e) {
            return redirect()->route('shop.storage.show', $store)->withErrors($e->getMessage());
        }
    }
}
