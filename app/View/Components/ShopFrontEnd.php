<?php

namespace App\View\Components;

use App\Models\PaymentMethod;
use App\Models\Shop;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;

class ShopFrontEnd extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public Shop $shop;
    public $paymentMethods;
    public function __construct()
    {

        $this->shop = Shop::where('user_name', request()->user_name)->first();
        $ids = $this->shop->footerPaymentMethod ?  json_decode($this->shop->footerPaymentMethod) : [];
        $this->paymentMethods = PaymentMethod::whereIn('id', $ids)->get();
        
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('layouts.shop-front-end');
    }
}
