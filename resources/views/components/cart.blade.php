<div id="mySidenav" data-state="off" class="cart p-0 ">

    <div class="cart-body container">

        <i class="fa fa-times m-3" onclick="toggleNav()"></i>
        @if (Cart::session(request('user_name'))->getTotalQuantity() > 0)
            <h1 class="text-center">{!! __('words.side_cart_heading') !!}</h1>

            <x-cart.products />
            <x-cart.cuppon />


            <x-cart.calculations :shop="$shop" />

            @auth
                @if (
                    (isset(auth()->user()->getShop()->id) &&
                        auth()->user()->getShop()->id == $shop->id &&
                        auth()->user()->self_checkout == '1') ||
                        $shop->hasSelfCheckout())
                    <x-cart.self_checkout :shop="$shop" />
                @else
                    <x-cart.shipping :shop="$shop" />
                @endif
            @else
                @if ($shop->hasSelfCheckout())
                    <x-cart.self_checkout :shop="$shop" />
                @else
                    <x-cart.shipping :shop="$shop" />
                @endif
            @endauth
        @else
            <h3 class="m-4 poppins text-center ">{{ __('words.cart_no_item_msg') }}</h3>
        @endif
    </div>


</div>
