<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use Cart;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add(Request $request, $user_name)
    {
        try {
            if ($request->variable_attribute) {
                $variation = json_encode($request->variable_attribute);
                $product = Product::where('parent_id', $request->product_id)->where('variation', $variation)->firstOrFail();
                if (!$product) {
                    return back()->withErrors('Sorry! This variation no longer available');
                }
            } else {
                $product = Product::find($request->product_id);
            }
            if ($request->quantity > $product->quantity) {

                return back()->withErrors('Sorry! This product has only ' . $product->quantity . ' quantity left');
            }
            $price = $product->currentPrice;
            Cart::session($user_name)->add([
                'id' => $product->id,
                'name' => $product->name,
                'price' => $price,
                'quantity' => $request->quantity,
                'attributes' => [
                    'timestamp' => now(),
                ],
            ])->associate('App\Models\Product');

            if ($request->method == 'self') {
                return redirect()->route('products', $user_name)->with('success_msg_cart', 'Item has been added to cart!');
            } else {
                return redirect()->back()->with('success_msg_cart', 'Item has been added to cart!');
            }
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        } catch (\Error $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
    public function scanner_cart_store(Request $request, $user_name)
    {
        $product = Product::where('ean', $request->ean)->where('shop_id', $request->shop_id)->first();
        if ($product) {
            $price = $product->currentPrice;
            Cart::session($user_name)->add($product->id, $product->name, $price, 1)->associate('App\Models\Product');
            Session::flash('success', 'Product added to cart successfully');
            return response()->json(['message' => 'Product added to cart successfully'], Response::HTTP_OK);
        }
        return response()->json(['message' => 'Product not found'], 404);
    }

    public function orderProduct($user_name, Product $product)
    {
        if ($product->saleprice) {
            $price = $product->saleprice;
        } else {
            $price = $product->price;
        }
        Cart::session($user_name)->add($product->id, $product->name, $price, 1)->associate('App\Models\Product');
        return redirect(route('cart', $user_name))->with('success_msg_cart', 'Item has been added to cart!');
    }
    public function update(Request $request)
    {

        $product = Product::find($request->product_id);
        if ($request->quantity > $product->quantity) {

            return back()->withErrors('Sorry! This product has only ' . $product->quantity . ' quantity left');
        }
        Cart::session(request('user_name'))->update($request->product_id, array(
            'quantity' => array(
                'relative' => false,
                'value' => $request->quantity
            ),
        ));
        return back()->with('success_msg_cart', 'Item has been updated!');
    }
    public function destroy($user_name, $id)
    {
        //return request('user_name');
        Cart::session(request('user_name'))->remove($id);
        return back()->with('success_msg_cart', 'Item has been removed!');
    }
}
