@php
    $url = url()->current();
@endphp
<div class="card">
    <div class="card-header border-transparent">
        <h3 class="card-title">{{ __('words.dashboard_order_table_title') }} </h3>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table m-0">
                <thead>
                    <tr>
                        <th>{{ __('words.manager_order_id') }}</th>
                        <th>{{ __('words.manager_order_item') }}</th>

                        <th>{{ __('words.manager_order_customer') }}</th>
                        <th>{{ __('words.manager_amount') }}</th>
                        <th>{{__('words.action')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td><a href="#">{{ $order->id }}</a></td>
                            <td>{{ App\Models\Package::find($order->package)->title }}</td>
                            <td>
                                <div class="sparkbar" data-color="#00a65a" data-height="20">
                                    {{ $order->first_name . ' ' . $order->last_name }}</div>
                            </td>
                            <td>
                                {{ $order->total }}
                            </td>
                            <td>
                                <a href="{{route('manager.invoice',$order)}}"><i class="fas fa-file"></i> invoice</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <div class="card-footer text-center">
        @if (str_contains($url, 'my-shop-dashboard'))
            {{-- <a href="{{route('shop.booking.callender')}}" >  {{ __('words.dashboard_all_View') }}</a> --}}
        @else
            <a href="{{ route('manager.booking.index') }}"> {{ __('words.dashboard_all_View') }}</a>
        @endif
    </div>

</div>
