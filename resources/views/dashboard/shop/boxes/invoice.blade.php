<x-dashboard.shop>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <button onclick="printDiv('printableArea')" class="btn btn-inline"><i class="fa fa-print"></i>
                        {!! __('words.print_btn') !!}</button>
                    </div>
                    <div class="card-body" id="printableArea">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <p><b>{!! __('words.invoice_customer_details') !!}</b></p>
                                            <p><b>{!! __('words.checkout_form_first_name_label') !!}:</b> {{ $order->first_name }}</p>
                                            <p><b>{!! __('words.checkout_form_lastname') !!}:</b>{{ $order->last_name }}</p>
                                            <p><b>{!! __('words.invoice_address') !!} :</b>{{ $order->address }}</p>
                                            <p><b>{!! __('words.city') !!} :</b>{{ $order->city }}</p>
                                            <p><b>{!! __('words.state') !!} :</b>{{ $order->state }}</p>
                                            <p><b>{!! __('words.zip') !!}:</b>{{ $order->post_code }}</p>
                                            <p><b>{!! __('words.invoice_tel') !!}:</b>{{ $order->phone }}</p>
                                            <p><b>{!! __('words.checkout_form_email') !!}:</b>{{ $order->email }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-sm-12">
                                            <h3 class="panel-title">{!! __('words.subs_invoice_subs_info') !!}</h3>
                                            <table class="table table-hover no-footer">
                                                <thead>
                                                    <tr role="row">
                                                        <th class="sorting" colspan="1" rowspan="1"
                                                            style="width: 15px;" tabindex="0">
                                                            {!! __('words.orders_id') !!}
                                                        </th>
                                                        <th class="sorting" colspan="1" rowspan="1"
                                                            style="width: 15px;" tabindex="0">
                                                            {!! __('title') !!}
                                                        </th>
                                                        <th class="sorting" colspan="1" rowspan="1"
                                                            style="width: 15px;" tabindex="0">
                                                            {!! __('words.subs_create_duration_label') !!}
                                                        </th>

                                                        <th class="sorting" colspan="1" rowspan="1"
                                                            style="width: 15px;" tabindex="0">
                                                          {!! __('paid_at') !!}
                                                        </th>
                                                        <th class="sorting" colspan="1" rowspan="1"
                                                            style="width: 15px;" tabindex="0">
                                                            {!! __('words.subs_show_subscription_fee') !!}
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td class="table-order">
                                                            <p>{{ $order->order_id }}</p>
                                                        </td>
                                                        <td>
                                                            <p>
                                                                {{ $order->box->title }}
                                                            </p>
                                                        </td>
                                                        <td>
                                                            {{ $order->box->duration->length }}  {{ @$order->box->duration->mode }}
                                                        </td>
                                                        <td class="table-date">
                                                            <p>{{ $order->paid_at?$order->paid_at->format('d M Y'):'Not Paid' }}</p>
                                                        </td>
                                                        <td class="table-total">
                                                            <p>{{ Iziibuy::price($order->subscriptionFee()) }}</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-sm-12">
                                            <h3 class="panel-title">{!! __('words.subs_invoice_subs_charges') !!}</h3>
                                            <table class="table table-hover no-footer">
                                                <tr>
                                                    <th>
                                                       {!! __('words.date_time') !!}
                                                    </th>
                                                    <th>
                                                        {!! __('words.charge') !!}
                                                    </th>
                                                    <th>
                                                        {!! __('words.dashboard_status') !!}
                                                    </th>
                                                </tr>
                                                @foreach ($order->charges as $charge)
                                                    <tr>
                                                        <td>
                                                            <div> {{ $charge->created_at }}</div>
                                                        </td>
                                                        <td>
                                                            <div> {{ Iziibuy::price($charge->amount) }}</div>
                                                        </td>
                                                        <td>
                                                            {{ $charge::STATUS[$charge->status] }}
                                                        </td>

                                                    </tr>
                                                @endforeach


                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
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

