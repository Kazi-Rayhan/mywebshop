<x-dashboard.user>

    <div class="row">
        <div class="col-lg-12">
            <div class="section-heading">
                <h2>{{ __('words.dashboard_subscription_title') }}</h2>
            </div>
        </div>
        <div class="col-lg-12">
            @if ($memberships->count() > 0)
            <div class="order-content">
                <table class="table-list">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('words.dashboard_order_no') }}</th>
                            <th scope="col">{{ __('words.subscription_index_title') }}</th>
                            <th scope="col">{{ __('words.date') }}</th>
                            <th scope="col">{{ __('words.subs_show_subscription_fee') }}</th>
                            <th scope="col">{{ __('words.dashboard_status') }}</th>
                            <th scope="col">{{ __('words.cart_table_action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($memberships as $order)
                        @if ($order->box)
                        <tr>
                            <td class="table-order">
                                <p>{{ $order->order_id }}</p>
                            </td>
                            <td>
                                <p>
                                    {{ $order->box->title }}
                                </p>
                            </td>
                            <td class="table-date">
                                <p>{{ $order->paid_at ? $order->paid_at->format('d M Y') : 'Not Paid' }}
                                </p>
                            </td>
                            <td class="table-total">
                                <p>{{ Iziibuy::price($order->subscriptionFee()) }}</p>
                            </td>
                            <td class="table-total">
                                <p class="btn btn-info btn-sm p-1">{{ $order->status() }}</p>
                                @if ($order->status == 0)
                                <a class="btn btn-danger p-1" href="{{ $order->payment_url }}" class="">Betal
                                    nå</a>
                                @endif
                            </td>
                            <td class="table-action">
                                <a target="_blank" href="{{ route('subscription.invoice', [request('user_name'), $order]) }}"><i class="fas fa-eye"></i></a>

                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <h3 class="text-center">{{ __('words.no_subscription') }}</h3>
            @endif
        </div>
    </div>
</x-dashboard.user>