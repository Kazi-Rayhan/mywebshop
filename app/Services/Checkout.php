<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Shipping;
use App\Models\Shop;
use App\Models\User;
use Exception;

class Checkout
{
    protected $user;
    protected $shop;
    protected int $total = 0;
    protected int $subtotal = 0;
    protected int $discount = 0;
    protected string $currency = 'NOK';
    protected int $tax = 0;
    protected int $shipping_cost = 0;
    protected  $shipping_method = null;
    protected  $country = null;
    protected bool $is_company = false;
    protected string  $payment_method = 'quickpay';
    protected $billing = [];
    protected $type = 0;
    protected $products;


    public  function __construct(Shop $shop, User $user = null, $products = null)
    {
        $this->user = $user;
        $this->shop = $shop;
        $this->products = $products;
    }
    public  function is_company()
    {
        $this->is_company = true;
        $this->payment_method = 'two';
    }

    public function booking()
    {
        $this->type = 1;
    }

    public function billing(array $data)
    {
        $this->billing = $data;
    }

    public function shipping(Shipping $shipping = null)
    {
        $this->shipping_method = $shipping;
        $this->shipping_cost = $shipping ? $shipping->costWithTax() : 0;
    }


    public function information($total = 0, $subtotal = 0, $tax = 0, $discount = 0, $currency = 'NOK')
    {
        $this->total = $total;
        $this->subtotal = $subtotal;
        $this->tax = $tax;
        $this->discount = $discount;
    }

    public function create()
    {
        $order = Order::create([
            'referral' => session('manager_id'),
            'user_id' => $this->user->id,
            'shop_id' => $this->shop->id,
            'subtotal' => $this->subtotal,
            'discount' => $this->discount,
            // 'discount_code' => $this->data->discount_code,
            'tax' => $this->tax,
            'shipping_cost' => $this->shipping_cost,
            'shipping_method' => $this->shipping_method,
            'currency' => $this->currency,
            'total' => $this->total,
            // 'store_id' => request()->store,
            'is_company' => $this->is_company,
            'type' => $this->type
        ]);
        $order->createMetas($this->billing);

        if ($this->products) {
            foreach ($this->products as $product) {
                $variations =  json_encode($product->model->variation);
                $order->products()->attach($product->model->id, [
                    'quantity' => $product->quantity,
                    'price' => $product->price,
                    'variation' => $variations,
                ]);
                $product->model->decrement('quantity', $product->quantity);
            }
        }

        return $order;
    }
}
