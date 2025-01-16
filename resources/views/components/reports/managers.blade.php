@php
    $url = url()->current();
@endphp
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('words.dashboard_members_table_title') }}</h3>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table">
            <tr>
                <th>
                    {{ __('words.name') }}
                </th>
                <th>
                    {{ __('words.contracts') }}
                </th>
                <th>

                    {{ __('words.this_month_sale') }}
                </th>
                <th>
                    {{ __('words.this_session') }}
                </th>
            </tr>
            @foreach ($manager as $person)
                @php
                    $q = App\Models\User::where('pt_trainer_id', $person->id);
                    $newq = clone $q;
                    $customers = $q->count();
                    $active = $newq
                        ->whereHas('credits', function ($query) {
                            $query
                                ->where(
                                    'shop_id',
                                    auth()
                                        ->user()
                                        ->getShop()->id,
                                )
                                ->hasCredits();
                        })
                        ->count();
                    $sale = App\Models\Order::whereHas('metas', function ($query) use ($person) {
                        $query->where('column_name', 'trainer')->where('column_value', $person->id);
                    })
                        ->where('status', 1)
                        ->when(request()->filled('from'), function ($query) {
                            $query->whereBetween('created_at', [request()->filled('from'), request()->filled('to')]);
                        })
                        ->sum('total');
                    
                    $total = App\Models\Booking::where('manager_id', $person->id)
                        ->where('service_type', 1)
                        ->sum(DB::raw('TIMESTAMPDIFF(MINUTE, start_at, end_at)'));
                    
                    $option = auth()
                        ->user()
                        ->getShop()->defaultOption;
                    if ($option) {
                        $result = round($total / $option->minutes);
                    } else {
                        $result = 0;
                    }
                    
                @endphp
                <tr>
                    <td>
                        {{ $person->name }}
                    </td>

                    <td>
                        <ul>
                            <li>
                                {{ __('words.manager_report_active') }} : {{ $active }}
                            </li>
                            <li>
                                {{ __('words.total') }} : {{ $customers }}
                            </li>
                        </ul>
                    </td>
                    <td>
                        {{ $sale }}
                    </td>

                    <td>
                        {{ $result }}
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="card-footer text-center">
        @if (str_contains($url, 'my-shop-dashboard'))
            <a href="{{ route('shop.booking.client.index') }}">{{ __('words.dashboard_all_View') }}</a>
        @else
            <a href="{{ route('manager.booking.client.index') }}">{{ __('words.dashboard_all_View') }}</a>
        @endif
    </div>

</div>
