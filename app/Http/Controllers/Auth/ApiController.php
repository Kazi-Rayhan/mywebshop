<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductCreateRequest;
use App\Http\Resources\Api\ProductResource;
use App\Http\Resources\Api\ProductsResource;
use App\Http\Resources\OrdersResource;
use App\Http\Resources\UsersResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function products(Shop $shop)
    {
        $products = Product::where('shop_id', $shop->id)
            ->whereNull('parent_id')
            ->when(request()->featured == true, function ($query) {
                $query->featured();
            });
        if (request()->filled('paginate')) {
            $products = $products->paginate(request()->paginate);
        } else {
            $products = $products->get();
        }

        return  ProductsResource::collection($products);
    }

    public function product(Shop $shop, Product $product)
    {
        return  ProductResource::make($product);
    }

    public function orders(Shop $shop)
    {
        $orders = Order::with(['metas', 'products'])->where('shop_id', $shop->id)
            ->when(request()->filled('payment_status'), function ($query) {
                $status = ['UNPAID', 'PAID'];
                $query->wehre('payment_status', array_keys($status, request()->payment_status));
            })
            ->when(request()->filled('status'), function ($query) {
                $status = ['PENDING', 'CONFIRMED', 'SHIPPED', 'CANCELED', 'NOT DELEIVERED', 'DELIVERED'];
                $query->wehre('status', array_keys($status, request()->status));
            })->when(request()->filled('payment_method'), function ($query) {
                $query->wehre('payment_method', request()->payment_method);
            });
        if (request()->filled('paginate')) {
            $orders = $orders->paginate(request()->paginate);
        } else {
            $orders = $orders->get();
        }

        return OrdersResource::collection($orders);
    }

    public function order(Shop $shop, Order $order)
    {

        return OrdersResource::make($order);
    }

    public function customers(Shop $shop)
    {
        $users = User::whereHas('orders', function ($query) use ($shop) {
            $query->where('shop_id', $shop->id);
        });
        if (request()->filled('paginate')) {
            $users = $users->paginate(request()->paginate);
        } else {
            $users = $users->get();
        }
        return UsersResource::collection($users);
    }


    public function createOrUpdate(Shop $shop, Request $request,Product $product = null)
    {

        $validator = Validator::make($request->all(), [
            "name"          => "required|max:200",
            "slug"          => "required|max:200|regex:/^\S*$/|unique:products,slug",
            "ean"           => "nullable|string",
            "price"         => "required|max:8|regex:/^\\d*(\\.\\d{1,2})?$/",
            "saleprice"     => "nullable|max:13|regex:/^\\d*(\\.\\d{1,2})?$/",
            "tax"           => "nullable|max:13|regex:/^\\d*(\\.\\d{1,2})?$/",
            "sku"           =>  "required|max:200",
            "quantity"      => "nullable|integer",
            "description"   => "nullable",
            "details"       => "nullable",
            "image"         => "nullable|mimes:jpg,jpeg,png",
            "images.*"      => "nullable|mimes:jpg,jpeg,png",
            "height"        => "nullable",
            "width"         => "nullable",
            "length"        => "nullable",
            "weight"        => "nullable",
            "is_variable" => "nullable",
            "status" => "nullable",
            "featured" => "nullable",
        ]);

        if ($validator->fails()) {
            return [
                'status' => false,
                'errors' => $validator->errors()
            ];
        }
        try {

            $imgs = [];
            if ($request->file('images')) {
                foreach ($request->file('images') as $img) {
                    $imgs[] = $img->store("products");
                }
            }



            $product = Product::updateOrCreate(['id' => @$product->id], [
                "shop_id"       => $shop->id,
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
            return $product;
        } catch (Exception $e) {
            return [
                'status' => false,
                'errors' => [
                  'message'=>  $e->getMessage()
                ]
            ];
        } catch (Error $e) {
            return [
                'status' => false,
                'errors' => [
                    'message'=>   $e->getMessage()
                ]
            ];
        }
    }
}
