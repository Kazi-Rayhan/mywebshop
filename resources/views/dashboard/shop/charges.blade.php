<x-dashboard.shop>
    
    <h3>{!! __('words.charge_sec_title') !!}</h3>
	<p>{!! __('words.charge_sec_pera') !!}  </p>

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card ">
                <div class="card-header">
                    @if (auth()->user()->shop->subscription_id)
                        <a onclick="confirm('Do you want to cancel your subscription?')" class="btn btn-danger btn-sm" href="{{route('shop.cancel-subscription')}}">{!! __('words.charge_cancel_subscription') !!}</a>
                    @else
                        <a class="btn btn-danger btn-sm" href="{{route('shop.enroll.subscription')}}">{!! __('words.charge_subscribe_again_btn') !!}</a>
                    @endif
                </div>
                <div class="card-body" id="printableArea">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    {!! __('words.order_btn') !!} id
                                </th>
                                <th>
                                    {!!__('words.charge_amount') !!}
                                </th>
                                <th>
                                    {!! __('words.charge_comment') !!}
                                </th>
                                <th>
                                    {!! __('words.charge_at') !!}
                                </th>
                                <th>
                                    {!! __('words.cart_table_action') !!}
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($charges as $charge)
                            <tr>
                                <td>
                                    {{$charge->order_id}}
                                </td>
                                <td>
                                    {{$charge->amount}} NOK
                                </td>
                                <td>
                                    {{$charge->comment}}
                                </td>
                               <td>
                                {{$charge->created_at->diffForHumans()}} &nbsp; <small> [{{$charge->created_at->format('d M, y h:i')}}] </small>
                               </td>
                               <td>
                                <a href="{{route('shop.charge.invoice',$charge)}}" class="btn btn-outline-info">{!! __('words.orders_invoice_btn') !!}</a>
                                <a href="{{route('shop.download.invoice',$charge)}}" class="btn btn-outline-info">{!! __('words.orders_download_btn') !!}</a>
                               </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')


    @endpush
</x-dashboard.shop>
