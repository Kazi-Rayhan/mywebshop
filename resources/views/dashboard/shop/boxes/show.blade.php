<x-dashboard.shop>
  
    <h3><span class="text-primary opacity-25"><i class="fas fa-list" aria-hidden="true"></i></span> {!! __('words.subs_show_sec_title') !!}
    </h3>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body shadow-lg">

                    @if ($box->memberships()->count() > 0)
                        <div class="order-content">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">{!! __('words.orders_id') !!}</th>
                                        <th scope="col">{!!__('words.subscription_index_title')  !!}</th>
                                        <th scope="col">{!! __('words.subs_show_paid_at') !!}</th>
                                        <th scope="col">{!! __('words.subs_show_subscription_fee') !!}</th>
                                        <th scope="col">{!! __('words.dashboard_status') !!}</th>
                                        <th scope="col">{!! __('words.cart_table_action') !!}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($box->memberships as $order)
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
                                                <p>{{ $order->paid_at?$order->paid_at->format('d M Y'):'Not Paid' }}</p>
                                            </td>
                                            <td class="table-total">
                                                <p>{{ Iziibuy::price($order->subscriptionFee()) }}</p>
                                            </td>
                                            <td class="table-total">
                                                <p class="btn btn-info btn-sm p-1">{{ $order->status() }}</p>

                                            </td>
                                            <td class="table-action">
                                                <a target="_blank"
                                                    href="{{ route('shop.subscriptionInvoice', [$order]) }}"><i
                                                        class="fas fa-eye"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <h3 class="text-center">{{ __('words.no_subscription') }} </h3>
                    @endif
                </div>
            </div>
        </div>
    </div>

     <script type="text/javascript">
                    function printDiv(divName) {
                        var printContents = document.getElementById(divName).innerHTML;
                        var originalContents = document.body.innerHTML;

                        document.body.innerHTML = printContents;

                        window.print();

                        document.body.innerHTML = originalContents;
                    }
                </script>
</x-dashboard.shop>
