<?php

namespace App\Http\Controllers\Dashboard\Shop;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductCreateRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Imports\ProductsImport;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Product;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::where('shop_id', auth()->user()->shop->id)->get();
        $products = Product::where('shop_id', auth()->user()->shop->id)
            ->when(request('pinned'), function ($query) {
                $query->where('pin', 1);
            })
            ->when(request('category'), function ($query) {
                $query->whereHas('categories', function ($query) {
                    $query->where('categories.id', request('category'));
                });
            })
            ->when(request('search'), function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'LIKE', "%" . request('search') . "%")
                        ->orWhere('id', 'LIKE', "%" . request('search') . "%")
                        ->orWhere('details', 'LIKE', "%" . request('search') . "%")
                        ->orWhere('description', 'LIKE', "%" . request('search') . "%");
                });
            })
            ->where('shop_id', auth()->user()->shop->id) // <-- Add this line
            ->orderByRaw('-pin asc')
            ->orderBy('order_no', 'asc')
            ->latest()
            ->paginate(request('paginate') ? request('paginate') : 25);

        return view('dashboard.shop.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('shop_id', auth()->user()->shop->id)->pluck('name', 'id');
        return view('dashboard.shop.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ProductCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function importProduct(Request $request)
    {
        // Validate request
        $request->validate([
            'sheet' => 'required|mimetypes:text/csv,text/plain,application/csv,text/comma-separated-values,text/anytext,application/octet-stream,application/txt,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
        //store sheet
        $sheet = $request->sheet->store('/uploads/sheets');
        $shop = auth()->user()->shop->id;
        try {
            Excel::import(new ProductsImport($shop), $sheet);
        } catch (Exception $e) {

            return redirect()->back()->withErrors($e->getMessage());
        } catch (Error $e) {

            return redirect()->back()->withErrors($e->getMessage());
        }
        Storage::delete($sheet);
        return back()->with('success', 'Your product is being imported in background please wait couple a miniute');
    }



    public function store(ProductCreateRequest $request)
    {

        $imgs = [];
        if ($request->file('images')) {
            foreach ($request->file('images') as $img) {
                $imgs[] = $img->store("products");
            }
        }



        $product = Product::create([
            "shop_id"       => auth()->user()->shop->id,
            "name"          => $request->name,
            "slug"          => $request->slug . '-' . uniqid(),
            "ean"           => $request->ean,
            "price"         => $request->price,
            "saleprice"     => $request->saleprice,
            "tax"           => $request->tax,
            "sku"           => $request->sku,
            "quantity"      => $request->quantity,
            "description"   => $request->description,
            "details"       => $request->details,
            "image"         => $request->image ? $request->image->store("products") : null,
            "images"      => $imgs,
            "height"        => $request->height,
            "width"         => $request->width,
            "length"        => $request->length,
            "weight"        => $request->weight,
            "is_variable"        => isset($request->variable) ? 1 : 0,
            "status"        => isset($request->status) ? 1 : 0,
            "featured"        =>  isset($request->featured)  ? 1 : 0,
        ]);
        $product->categories()->attach($request->categories);


        $product->save();
        return redirect(route('shop.products.index'))->with('success', 'Product created');
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
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {

        if ($product->shop_id != auth()->user()->shop->id) abort(403);
        $categories = Category::where('shop_id', auth()->user()->shop->id)->pluck('name', 'id');
        return view('dashboard.shop.products.edit', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Product\ProductUpdateRequest  $request
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {

        if ($product->shop_id != auth()->user()->shop->id) abort(403);
        $images = $product->images;
        if ($images) {
            foreach ($images as $key => $image) {
                if (!Storage::exists($image)) {
                    unset($images[$key]);
                }
            }
        }

        $imgs = [];
        if ($request->file('images')) {
            foreach ($request->file('images') as $img) {
                $imgs[] = $img->store("products");
            }
        }
        if ($request->image) {
            $product->update([
                'image' => $request->file('image')->store("products")
            ]);
        }
        // if (!empty($product->image)) {
        //     Storage::delete($product->image);
        // }

        $imgs = array_merge($images, $imgs);


        $product->update([
            "shop_id"       => auth()->user()->shop->id,
            "name"          => $request->name,
            "slug"          => $request->slug,
            "ean"           => $request->ean,
            "price"         => $request->price,
            "saleprice"     => $request->saleprice,
            "tax"           => $request->tax,
            "sku"           => $request->sku,
            "quantity"      => $request->quantity,
            "description"   => $request->description,
            "details"       => $request->details,
            //"image"         => $request->image ? $request->image->store("products") : null,
            "images"      => $imgs,
            "height"        => $request->height,
            "width"         => $request->width,
            "length"        => $request->length,
            "weight"        => $request->weight,
            "is_variable"        => isset($request->variable) ? 1 : 0,
            "status"        => isset($request->status) ? 1 : 0,
            "featured"        =>  isset($request->featured)  ? 1 : 0,
        ]);
        $product->categories()->sync($request->categories);


        $product->save();

        return redirect(route('shop.products.index'))->with('success', 'Product created');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->shop_id != auth()->user()->shop->id) abort(403);
        $images = $product->images ?? [];
        if (!empty($images)) {
            Storage::delete($images);
        }

        if (!empty($product->image)) {
            Storage::delete($product->image);
        }
        $product->delete();
        return redirect()->back()->with('success', 'Product Deleted');
    }


    public function order(Request $request)
    {
        foreach ($request->products as $product) {
            Product::where('id', $product['id'])->update([
                'order_no' => $product['order_no']
            ]);
        }
    }

    public function change_status(Request $request)
    {
        $request->validate([
            'status' => 'required|in:0,1',
            'product' => 'required'
        ]);

        Product::whereIn('id', $request->product)
            ->update(['status' => $request->status]);

        return redirect()->back()->with('success', "Products status changed");
    }

    public function pin(Product $product)
    {

        $product->update([
            'pin' => $product->pin ? 0 : 1,
        ]);

        return back()->with('success', 'Product Pinned successfully');
    }


    public function store_attribue(Request $request)
    {
        Attribute::create([
            'name' => str_replace(' ', '_', $request->attr_name),
            'value' =>  $request->attr_value,
            'product_id' => $request->product_id,
        ]);
        return back()
            ->with([
                'message'    => "Attribute Added",
                'target'     => "attribute",
                'scroll'     => "scroll",
                'alert-type' => 'success',
            ]);
    }
    public function update_attribue(Request $request)
    {
        $value = json_encode(explode(',', $request->attr_value));
        Attribute::where('id', $request->attr_id)->update([
            'name' => str_replace(' ', '_', $request->attr_name),
            'value' =>  $value,
        ]);
        return back()
            ->with([
                'message'    => "Attribute Updated",
                'target'     => "attribute",
                'scroll'     => "scroll",
                'alert-type' => 'success',
            ]);
    }

    public function delete_attribue(Attribute $attribute)
    {
        $attribute->delete();

        return back()
            ->with([
                'message'    => "Attribute deleted",
                'target'     => "attribute",
                'scroll'     => "scroll",
                'alert-type' => 'success',
            ])
            ->with('new-attribute', true);
    }

    public function create_variation(Product $product)
    {
        if ($product->shop_id != auth()->user()->shop->id) abort(403);
        // return $product->shop->user_name;
        $new_product = Product::create([

            'parent_id' => $product->id,
            'details' => $product->details,
            'name' => $product->name,
            'image' => $product->image,
            'price' => $product->price,
            'saleprice' => $product->saleprice,
            'quantity' => $product->quantity,
            'sku' => $product->sku,
        ]);

        // $data = $new_product->update([
        //     'qrcode' => Shop::qrcode(route('cart.store', ['user_name' => Shop::idToUserName($product->shop_id), 'product_id' => $new_product->id, 'quantity' => 1]))
        // ]);

        return back()
            ->with([
                'message'    => "Product Added",
                'target'     => "variation",
                'scroll'     => "scroll",
                'alert-type' => 'success',
            ])
            ->with('new-attribute', true);
    }

    public function update_variation(Request $request, Product $product)
    {

        $product->update([
            'variation' => $request->variation,
            'price' => $request->variable_price,
            'quantity' => $request->variable_stock,
            'saleprice' => $request->saleprice,
            'length' => $request->length,
            'width' => $request->width,
            'height' => $request->height,
            'weight' => $request->weight,
            'sku' => $request->variable_sku,
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('products');
            $product->update([
                'image' => $image
            ]);
        }

        return back()
            ->with([
                'message'    => "Product updated",
                'target'     => "variation",
                'scroll'     => "scroll",
                'alert-type' => 'success',
            ])
            ->with('new-attribute', true);
    }

    public function delete_variation(Product $product)
    {

        $product->delete();

        return back()
            ->with([
                'message'    => "Variation deleted",
                'target'     => "variation",
                'scroll'     => "scroll",
                'alert-type' => 'success',
            ])
            ->with('new-vaiation', true);
    }

    public function affiliate_variation(Product $product)
    {

        return 'Unfinished';
        // $managers = Auth::user()->shop->users()->where('role_id', 4)->get();
        // foreach ($managers as $manager) {
        //     if (env('APP_DEBUG') == false) {
        //         $qr = Shop::qrcode(route('order.product', ['product' => $product->id, 'user_name' => auth()->user()->shop->user_name, 'manager_id' => $manager->id]));
        //     } else {

        //         $qr = null;
        //     }
        //     $chk = UserProduct::where('user_id', $manager->id)->where('product_id', $product->id)->first();
        //     if ($chk) {
        //         $product->affiliats()->sync($manager, ['qr' => $qr]);
        //     } else {
        //         $product->affiliats()->attach($manager, ['qr' => $qr]);
        //     }
        // }
        // return redirect()->back()->with('success', 'Qr created');
    }
}
