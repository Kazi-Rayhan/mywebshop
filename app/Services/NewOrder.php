<?php

namespace App\Services;

use App\Mail\OrderPlaced;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductStore;
use App\Models\Shop as ModelsShop;
use App\Models\User;
use Error;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Shop;
use Iziibuy;
use Illuminate\Support\Facades\Validator;

class NewOrder
{

    protected $user;
    protected $shop;
    protected $product;
    protected $data;

    public function __construct(User $user, Product $product, ModelsShop $shop)
    {
        $this->user = $user;
        $this->shop = $shop;
        $this->product = $product;
        $this->data = [
            'name'       => auth()->user()->name ?? "Guest",
            'last_name'  =>  auth()->user()->last_name ?? "User",
            'email'      =>  auth()->user()->email ?? setting('site.email'),
            'phone'      =>  auth()->user()->phone ?? '',
            'address'    =>   auth()->user()->address ?? '',
            'city'       =>  auth()->user()->city ?? '',
            'state'       =>  auth()->user()->state ?? '',
            'post_code'  =>  auth()->user()->post_code ?? '',
            'country' =>  auth()->user()->country ?? ''
        ];
    }


    public static function ingridents(User $user, Product $product, ModelsShop $shop)
    {

        return new static($user, $product, $shop);
    }




    protected function needsToUpdateProfile($userData)
    {
        $validator = Validator::make($userData, [
            "name"    => "required|string",
            "last_name"  => "required|string",
            "email" => "required|email",
            "phone" => "nullable|string",
            "address" => "nullable|string",
            "city" => "nullable|string",
            "state" => "nullable|string",
            "post_code" => "nullable|string|max:10",
            "country" => "nullable|string",
        ]);

        return $validator->fails();
    }

    public function cook(): Order
    {

        if ($this->needsToUpdateProfile($this->data)) throw new Exception('Please update profile and address by clicking edit button then confirm order');
        if ($this->product->quantity <= 0)  throw new Exception('Not enough product in stock');
        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $this->user->id ?? null,
                'shop_id' => $this->shop->id,
                'referral_code' => session('manager_id'),
                'type'=>0,
                'subtotal' => Iziibuy::round_num($this->product->originalPrice),
                'tax' => Iziibuy::round_num($this->product->tax_amount),
                'total' => Iziibuy::round_num($this->product->price),
                'payment_method'=>$this->shop->paymentMethod,
                'currency'=> Iziibuy::currency()
            ]);

            $order->createMetas([
                'first_name' => $this->data['name'],
                'last_name' => $this->data['last_name'],
                'email' => $this->data['email'],
                'address' => $this->data['address'],
                'city' => $this->data['city'],
                'post_code' => $this->data['post_code'],
                'state' => $this->data['state'],
                'phone' => $this->data['phone'],

            ]);
            $order->products()->attach($this->product->id,[
                'quantity' => 1,
                'price' => $this->product->price,
            ]);

            $this->product->decrement('quantity', 1);

            $order->save();
            DB::commit();

            $message =  '<br>Her er dine detaljer for din ordre plassert den ' . $order->created_at->format('M d, Y') . ' hos ' . $order->shop->name . ' <br><br><b>Vennligst betal nå for å bekrefte din ordre:</b><br>';
            Mail::to($order->email)->queue(new OrderPlaced($order, false, $message));

            return $order;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        } catch (Error $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
