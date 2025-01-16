<div class="card">
    <div class="card-header">
        <h4>{{ $title }}</h4>
    </div>
    <div class="card-body">

        <table class="table">

            <thead>
               
                <tr>
                    <th>{{ __('words.customer') }}</th>

                    <th>{{ __('words.service') }}</th>
                    <th colspan="2">{{ __('words.appointment') }}</th>
                
                </tr>
            </thead>
            <tbody>
                @if ($bookings->count() > 0)
                    @foreach ($bookings as $booking)
                        <tr>
                            <td>
                                {{ $booking->customer->full_name }}
                                <br>
                                Phone : {{ $booking->customer->phone }}
                            </td>

                            <td>
                                {{ $booking->service->name }}
                            </td>

                            <td colspan="2">
                                {{ $booking->start_at->format('H:i A') }} -
                                {{ $booking->end_at->format(' H:i A') }} <br>
                                {{ $booking->end_at->format('d M,Y') }}
                            </td>

                        </tr>
                        @if (json_decode($booking->log))
                            <tr>
                            </tr>
                            <tr>
                                <th colspan="6">
                                    {{ __('words.btn_re_schedule') }}
                                </th>
                            </tr>
                            @foreach (json_decode($booking->log) as $log)
                                <tr>
                                    <td colspan="1">
                                        <h5>{{ $loop->iteration }}</h5>
                                    </td>
                                    <td colspan="3">

                                        <table class="table">
                                            <tr>
                                                <th>
                                                    {{ __('words.from') }}
                                                </th>
                                                <td>
                                                    {{ Carbon\Carbon::parse($log->from->start_at)->format('H:i A') }}
                                                    -
                                                    {{ Carbon\Carbon::parse($log->from->end_at)->format('H:i A') }}
                                                    <br>
                                                    {{ Carbon\Carbon::parse($log->from->start_at)->format('d M,Y') }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td colspan="2">
                                        <table class="table">
                                            <tr>
                                                <th>
                                                    {{ __('words.to') }}
                                                </th>
                                                <td>
                                                    {{ Carbon\Carbon::parse($log->to->start_at)->format('H:i A') }}
                                                    -
                                                    {{ Carbon\Carbon::parse($log->to->end_at)->format('H:i A') }}
                                                    <br>
                                                    {{ Carbon\Carbon::parse($log->to->start_at)->format('d M,Y') }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>


                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                    <tr>
                        <td colspan="5">
                            {{ $bookings->links() }}
                        </td>
                    </tr>
                @else
                    <td colspan="6">
                        <h1 class="text-center">{{ __('words.manager_product_not_msg') }}</h1>
                    </td>
                @endif
            </tbody>
        </table>
    </div>
</div>
