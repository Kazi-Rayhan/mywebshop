<x-dashboard.user>

    <h3>{{ __('words.dashboard_order_title') }}</h3>

    <div class="row">
        <div class="col-lg-12">
            <form action="" method="get">
                <x-form.input type="select" name="payment_status" label="{!! __('words.order_payment_status') !!}" :options="[__('words.Unpaid'), __('words.Paid')]"
                    value="{{ request()->payment_status }}" />
                <button class="btn btn-outline-primary" style="float:right">{{ __('words.filter') }}</button>
            </form>
            @if ($orders->count() > 0)
                <div class="order-content">
                    <table class="table-list col-md-12 col-sm-12">
                        <thead>
                            <tr>
                                <th scope="col">{{ __('words.dashboard_order_no') }}</th>
                                <th scope="col">{{ __('words.dashboard_order_shop_name') }}</th>
                                <th scope="col">{{ __('words.orders_order_date') }}</th>
                                <th scope="col">{{ __('words.cart_account_table_title') }}</th>
                                <th scope="col">{{ __('words.dashboard_status') }}</th>
                                <th scope="col">{{ __('words.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td class="table-order">
                                        <p>{{ $order->id }}</p>
                                    </td>
                                    <td>
                                        <a
                                            href="{{ route('shop.home', $order->shop->user_name) }}">{{ $order->shop->name }}</a>
                                    </td>
                                    <td class="table-date">
                                        <p>{{ $order->created_at->format('d M Y') }}</p>
                                    </td>
                                    <td class="table-total">
                                        <p>{{ Iziibuy::price($order->total, $order->currency) }}</p>
                                    </td>
                                    <td class="table-total">
                                        {{$order->status()}}

                                    </td>
                                    <td class="table-action">
                                        @if ($order->status == 0)
                                            <a class="btn btn-danger p-1"
                                                href="{{ route('payment', ['user_name' => request('user_name'), 'order' => $order]) }}"
                                                class="">{{ __('words.orders_pay_btn') }}</a>
                                        @endif
                                        
                                        <a target="_blank" class="btn btn-primary p-1"
                                            href="{{ route('user.invoice', ['order' => $order, 'user_name' => request('user_name')]) }}"> {{__('words.invoice')}}</a>
                                        @if ($order->is_company)
                                            @if ($order->payment_status == '2')
                                                <a title="download Invoice"
                                                    href="{{ (new App\Payment\Two\TwoPayment($order->shop, $order))->invoice() }}"><i
                                                        class="fa fa-file-invoice mr-2"></i></a>
                                            @endif
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <h3 class="text-center"> Ingen registrerte ordre </h3>
            @endif
        </div>
    </div>

</x-dashboard.user>
