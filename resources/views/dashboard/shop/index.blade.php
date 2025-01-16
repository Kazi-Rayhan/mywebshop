<x-dashboard.shop>

    @push('styles')
        <style>
            .table td {
                vertical-align: middle
            }
        </style>
    @endpush




    <h3><span class="text-primary opacity-25">{!! __('words.dashboard_welcome') !!}</span> {{ Auth::user()->shop->name }}</h3>
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-stats  mb-4 p-3">
                    <x-qr.direct :size="200" :url="route('shop.home', auth()->user()->shop->user_name)" />

                </div>
            </div>
            <x-widget :label="__('words.shop_orders_paid')" :icon="'fas fa-cash-register'" data="{{ $orders['paid'] }}" :link="route('shop.order.index', ['payment_status' => 1, 'status' => 5])" />

            <x-widget :label="__('words.shop_orders_undelivered')" :icon="'fas fa-cash-register'" data="{{ $orders['undelivered'] }}" :link="route('shop.order.index', ['payment_status' => 1, 'status' => 4])" />
            <x-widget :label="__('words.shop_orders_pending')" :param="['status' => '0']" :icon="'fas fa-cash-register'" data="{{ $orders['pending'] }}"
                :link="route('shop.order.index', ['status' => 0])" />
            <x-widget :label="__('words.shop_orders_canceled')" :param="['status' => '3']" :icon="'fas fa-cash-register'" data="{{ $orders['cancel'] }}"
                :link="route('shop.order.index', ['status' => 3])" />
            <x-widget :label="__('words.dashboard_coupons')" :icon="'fas fa-tags'" data="{{ $coupons }}" :link="route('shop.coupon.index')" />
            <x-widget :label="__('words.dashboard_managers')" :icon="'fas fa-users-cog'" data="{{ $managers }}" :link="route('shop.managers')" />
            <x-widget :label="__('words.dashboard_month_sale')" :icon="'fas fa-chart-line'" data="{{ Iziibuy::price($monthly_sales) }}" />
            <x-widget :label="__('words.dashboard_todays_sale')" :icon="'fas fa-chart-line'" data="{{ Iziibuy::price($todays_sales) }}" />

        </div>
    </div>
</x-dashboard.shop>