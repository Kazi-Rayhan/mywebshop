<?php

namespace App\Http\Controllers\Dashboard\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryCreateRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categories = Category::where('shop_id', auth()->user()->shop->id)->orderBy('order_no', 'ASC')->paginate(10);
        return view('dashboard.shop.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = Category::where('shop_id', auth()->user()->shop->id)->pluck('name', 'id');

        return view('dashboard.shop.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\CategoryCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryCreateRequest $request)
    {

        $category = Category::create([
            'shop_id' => auth()->user()->shop->id,
            'name' => $request->name,
            'slug' => $request->slug,
            'parent_id' => $request->category,
            'order_no' => $request->order_no,
        ]);


        // $category = tap($category, function ($category) {
        //     if (!env('APP_DEBUG')) {
        //         $category->update([
        //             'qrcode' => Shop::qrcode(route('products', [
        //                 'user_name' => auth()->user()->shop->user_name,
        //                 'category' => $category->slug,
        //             ])),
        //         ]);
        //     }
        // });

        return redirect(route('shop.categories.index'))->with('success', 'Category Created');
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
    public function edit(Category $category)
    {
        if ($category->shop_id != auth()->user()->shop->id) abort(403);
        $categories = Category::where('shop_id', auth()->user()->shop->id)->where('id', '!=', $category->id)->pluck('name', 'id');

        return view('dashboard.shop.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryCreateRequest $request, Category $category)
    {

        if ($category->shop_id != auth()->user()->shop->id) abort(403);
        $category->update([
            'name' => $request->name,
            'slug' => $request->slug,
            'parent_id' => $request->category,
            'order_no' => $request->order_no,
        ]);
        return redirect(route('shop.categories.index'))->with('success', 'Category Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {

        if ($category->shop_id != auth()->user()->shop->id) abort(403);
        $category->delete();
        return redirect(route('shop.categories.index'))->with('success', 'Category Deleted');
    }

    public function order(Request $request)
    {
        foreach ($request->categories as $category) {
            Category::where('id', $category['id'])->update([
                'order_no' => $category['order_no']
            ]);
        }
    }
}
