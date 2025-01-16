<x-dashboard.user>

    <h3>
        {{ __('words.booking') }}
    </h3>
    <div class="table-responsive">
        <table class="table table-condensed">

            <thead>
                <tr>
                    Duration
                </tr>
                <tr>

                    <th>{{ __('words.dashboard_managers') }} </th>
                    <th>{{ __('words.service') }}</th>
                    <th>{{ __('words.appointment') }}</th>
                    <th>{{ __('words.dashboard_status') }}</th>
                    <th>{{ __('words.payment_status') }}</th>

                </tr>
            </thead>
            <tbody>
                @if ($bookings->count() > 0)
                    @foreach ($bookings as $booking)
                        <tr>

                            <td>
                                {{ $booking->manager->full_name }} <small>-
                                    {{ $booking->shop->user_name }}</small>
                                <br>
                                Phone : {{ $booking->manager->phone }}
                            </td>
                            <td>
                                {{ $booking->service->name }}
                            </td>

                            <td>
                                {{ $booking->start_at->format('H:i A') }} -
                                {{ $booking->end_at->format(' H:i A') }} <br>
                                {{ $booking->end_at->format('d M,Y') }}
                            </td>

                            <td>
                                {{ $booking->status }}
                            </td>
                            <td>
                                {{ $booking->payment_status }}
                            </td>

                            <td>
                                <a class="btn btn-primary"
                                    href="{{ route('user.bookingsingle', [request()->user_name, 'booking' => $booking]) }}">{{ __('words.view_btn') }}</a>
                            </td>

                        </tr>
                    @endforeach
                @else
                    <td colspan="6">
                        <h1 class="text-center">
                            {{ __('words.dashboard_no_order_msg') }}
                        </h1>
                    </td>
                @endif
            </tbody>
        </table>
    </div>


</x-dashboard.user>
