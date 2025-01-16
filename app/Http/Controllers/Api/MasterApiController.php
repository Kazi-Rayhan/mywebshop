<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\ProductCreateRequest;
use App\Http\Resources\Api\ProductResource;
use App\Http\Resources\Api\ProductsResource;
use App\Http\Resources\AreaResource;
use App\Http\Resources\OrdersResource;
use App\Http\Resources\UsersResource;
use App\Models\Area;
use App\Models\Order;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Error;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MasterApiController extends Controller
{
    public function products()
    {
        $products = Product::whereNull('parent_id')
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

    public function product(Product $product)
    {
        return  ProductResource::make($product);
    }

    public function orders()
    {
        $orders = Order::with(['metas', 'products'])->when(request()->filled('payment_status'), function ($query) {
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

    public function order(Order $order)
    {

        return OrdersResource::make($order);
    }

    public function customers()
    {
        $users = User::has('orders');
        if (request()->filled('paginate')) {
            $users = $users->paginate(request()->paginate);
        } else {
            $users = $users->get();
        }
        return UsersResource::collection($users);
    }


    public function createOrUpdate(Request $request, Product $product = null)
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
                "shop_id"       => $request->shop_id,
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
                "areas" => $request->area
            ]);
            $product->categories()->attach($request->categories);


            $product->save();
            return $product;
        } catch (Exception $e) {
            return [
                'status' => false,
                'errors' => [
                    'message' =>  $e->getMessage()
                ]
            ];
        } catch (Error $e) {
            return [
                'status' => false,
                'errors' => [
                    'message' =>   $e->getMessage()
                ]
            ];
        }
    }

    public function areas()
    {
        $areas = Area::all();
        return AreaResource::collection($areas);
    }
    public function areasCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'key' => 'required|unique:areas,key|regex:/^\S*$/'
        ]);
        if ($validator->fails()) {
            return [
                'status' => false,
                'errors' => $validator->errors()
            ];
        }
        try {
            return Area::create([
                'name' => $request->name,
                'key' => $request->key
            ]);
        } catch (Exception $e) {
            return [
                'status' => false,
                'errors' => [
                    'message' =>  $e->getMessage()
                ]
            ];
        } catch (Error $e) {
            return [
                'status' => false,
                'errors' => [
                    'message' =>  $e->getMessage()
                ]
            ];
        }
    }
}
