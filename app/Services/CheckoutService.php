<?php

namespace App\Services;

use App\Exceptions\ShippingNotAvilableException;
use App\Exceptions\UpdateProfileException;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductStore;

use App\Models\Shop as ModelsShop;
use App\Models\ShopProduct;
use App\Payment\Two\TwoPayment;
use Error;
use Cart;
use Iziibuy;
use Exception;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CheckoutService
{

    protected const RULES_IF_SHIPPING_METHOD_EXISTS = [
        'name'       => ['required'],
        'last_name'  => ['required'],
        'email'      => ['required', 'email'],
        'phone'      => ['required'],
        'address'    => ['required'],
        'city'       => ['required'],
        'post_code'  => ['required', 'string'],
        'country' => ['required']
    ];

    protected const RULES_IF_SHIPPING_METHOD_DO_NOT_EXISTS = [
        'name'       => ['required'],
        'last_name'  => ['required'],
        'email'      => ['required', 'email'],
        'phone'      => ['required']
    ];

    protected const RULES_IF_ORDER_IS_FOR_COMPANY = [
        'name'       => ['required'],
        'last_name'  => ['required'],
        'email'      => ['required', 'email'],
        'phone'      => ['required'],
        'address'    => ['required'],
        'city'       => ['required'],
        'post_code'  => ['required', 'string'],
        'country' => ['required'],
        'company_name' => ['required'],
        'company_id' => ['required'],
        'company_country_prefix' => ['required'],
    ];
    protected $data;
    protected $shipping;
    protected $shop;
    protected $validation;

    protected $shipping_cost = 0;
    public function __construct($data, $shipping = null, $validation = true)
    {
        $this->validation = $validation;

        $this->data = (object) $data;


        if (isset($this->data->shop_id) && $this->data->shop_id) {
            $this->shop = ModelsShop::where('id', $this->data->shop_id)->first();
        } else {
            $this->shop = ModelsShop::where('user_name', request()->user_name)->first();
        }
        $this->shipping = $shipping;
        if ($this->shipping) {
            $this->shipping_cost = $this->shipping->costWithTax();
        }
    }



    protected function needsToUpdateProfile()
    {

        if (request()->reference === "self") return false;
        if ($this->validation == false) return false;
        if ($this->shipping) {
            if (request()->payment == 'company') {
                $validator = Validator::make((array) $this->data, $this::RULES_IF_ORDER_IS_FOR_COMPANY);
            } else {
                $validator = Validator::make((array) $this->data, $this::RULES_IF_SHIPPING_METHOD_EXISTS);
            }
        } else {
            $validator = Validator::make((array) $this->data, $this::RULES_IF_SHIPPING_METHOD_DO_NOT_EXISTS);
        }

        return $validator->fails();
    }

    public function decreaseQuantities($request)
    {

        foreach (Cart::session(request('user_name'))->getContent() as $item) {
            $product = Product::find($item->model->id);
            $product->decrement('quantity', $item->quantity);
        }
    }

    protected function checkIfShippingIsValid()
    {
        return in_array($this->data->country, $this->shipping->locations);
    }


    public function store()
    {
       

        if ($this->shipping && !$this->checkIfShippingIsValid() && !auth()->check()) throw new ShippingNotAvilableException();
        if (auth()->check() && $this->needsToUpdateProfile()) throw new UpdateProfileException();
        // try {
        $subtotal = $this->data?->subtotal  ?? Iziibuy::round_num(Cart::session(request('user_name'))->getSubTotal() - Iziibuy::tax());
   
        // $shipping = $subtotal >= $this->shop->free_shiping_after ? 0 : $this->shipping_cost;
        $shipping = $this->shipping_cost;
        $default = ModelsShop::where('user_name', request()->user_name)->first()->default_currency ?? auth()->user()->shop->default_currency ?? @$shop->default_currency;
        $current =  $default;
        
        $order = Order::create([
            'user_id' => $this->data->user_id ?? auth()->user()->id ?? null,
            'shop_id' => $this->data->shop_id ?? Iziibuy::userNameToId(request('user_name')),
            'referral_code' => session('manager_id'),
            'subtotal' => Iziibuy::onlyPrice(($this->data?->subtotal  ?? Iziibuy::round_num(Cart::session(request('user_name'))->getSubTotal() - Iziibuy::tax())), $this->shop, $current),
            'discount' => Iziibuy::onlyPrice(Iziibuy::round_num(Iziibuy::discount()), $this->shop, $current),
            'discount_code' => Iziibuy::discount_code(),
            'tax' => Iziibuy::onlyPrice(($this->data?->tax ?? Iziibuy::round_num(Iziibuy::tax())), $this->shop, $current),
            'shipping_cost' => Iziibuy::onlyPrice($shipping, $this->shop, $current),
            'payment_method' => $this->data->payment_method,
            'shipping_method' => @$this->shipping->id,
            'total' => Iziibuy::onlyPrice(($this->data?->total ?? Iziibuy::round_num(Iziibuy::newTotal()) + $shipping), $this->shop, $current),
            'store_id' => request()->store,
            'is_company' => request()->payment == 'company' ? 1 : 0,
            'type' => $this->data->type ?? 0,
            'currency' => $current,
            'payment_status' => 0,
        ]);
 
        $meta = [
            'first_name' =>   $this->data->name,
            'last_name' => $this->data->last_name,
            'email' => $this->data->email,
            'phone' => $this->data->phone,
            'is_vcard' => $this->data->is_vcard ?? 0
        ];
        //$qrcode = Iziibuy::qrcode(route('payment', [$order->shop->user_name, $order]));
        if ($order->is_company) {

            $meta = array_merge($meta, [
                'address' =>  $this->data->address,
                'city' => $this->data->city,
                'country' => $this->data->country,
                'post_code' => $this->data->post_code,
                'state' => $this->data->state,
                'company_name' => $this->data->company_name,
                'company_id' => $this->data->company_id,
                'company_country_prefix' => $this->data->company_country_prefix,
            ]);
        } else {
            if ($this->shipping) {
                $meta = array_merge($meta, [
                    'address' =>  $this->data->address,
                    'city' => $this->data->city,
                    'country' => $this->data->country,
                    'post_code' => $this->data->post_code,
                    'state' => $this->data->state,
                    //'qrcode' => $qrcode,
                ]);
            }
        }

        $order->createMetas($meta);
        if (request('user_name')) {

            foreach (Cart::session(request('user_name'))->getContent() as $item) {
                $variations =  json_encode($item->model->variation);
                $order->products()->attach($item->model, [
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'variation' => $variations,
                ]);
            }
        }
        if (request('user_name')) {
            $this->decreaseQuantities(request());
        }
        if (!auth()->check()) {
            session()->put('order', $order->id);
        }

        if (request()->has('reference')) $order->createMeta('reference', request()->reference);

        if (request()->has('create_a_account')) $order->createMeta('create_a_account', true);




        $order->save();

        if (request()->payment == 'company') {
            $orderIntent = (new TwoPayment($order->shop, $order))->orderIntent();

            if (isset($orderIntent->error_details)) {
                throw new Exception($orderIntent->error_details);
            }
            if (!isset($orderIntent->approved)) {
                throw new Exception('Please check you address mobile number if correct then then from your company payment can not be processed. Try with different company');
            }
        }



        return $order;
        // } catch (Exception $e) {
        //     throw $e;
        // } catch (Error $e) {
        //     throw $e;
        // }
    }
}
