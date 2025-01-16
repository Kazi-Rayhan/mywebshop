<x-dashboard.shop>    
    <h3 class="d-print-none"><span class="text-primary opacity-25 ">{!! __('words.shop_reserve') !!} Shop</span> {{ __('words.shop_reserve_2') }}</h3>
    <div class="row mt-3 d-print-none">
        <div class="col ">
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-condensed">

                            <thead>
                                <tr>
                                    <form action="{{ url()->current() }}">
                                        <td colspan="6">
                                            <div class="form-group">
                                                <label for="filter">{{ __('words.filter_btn') }}</label>
                                                <select name="status" id="filter" class="form-control">
                                                    <option value="" @if (request()->status == '') selected @endif>
                                                        All</option>
                                                    <option value="1" @if (request()->status == '1') selected @endif>
                                                        Completed</option>
                                                    <option value="0" @if (request()->status == '0') selected @endif>
                                                        Pending</option>
                                                    <option value="2" @if (request()->status == '2') selected @endif>
                                                        Expaired</option>
                                                </select>
                                            </div>
                                            <button class="btn btn-primary">
                                                {{ __('words.filter_btn') }}
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                                <tr>
                                    <th>{{ __('words.customer') }}</th>
                                    <th>{{ __('words.dashboard_managers') }} </th>
                                    <th>{{ __('words.service') }}</th>
                                    <th>{{ __('words.appointment') }}</th>
                                    <th>{{ __('words.dashboard_status') }}</th>
                                    <th>{{ __('words.payment_status') }}</th>
                                    <th>{{ __('words.orders_invoice') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($bookings->count() > 0)
                                    @foreach ($bookings as $booking)
                                        <tr>
                                            <td>
                                                {{ $booking->customer->full_name }}
                                                <br>
                                                  Phone : {{$booking->customer->phone}}
                                            </td>
                                            <td>
                                                {{ $booking->manager->full_name }}
                                                <br>
                                                  Phone : {{$booking->manager->phone}}
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
                                                <div class="btn-group">
                                                    @if ($booking->status == 'Pending')
                                                        <a href="{{ route('shop.booking.status.completed', $booking) }}"
                                                            class="btn btn-success btn-sm" title="Completed">
                                                            <i class="fa fa-check"></i>
                                                        </a>
                                                    @endif

                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="6">
                                            {{ $bookings->links() }}
                                        </td>
                                    </tr>
                                @else
                                    <td colspan="6">
                                        <h1 class="text-center">Ingen ordre registrert</h1>
                                    </td>
                                @endif
                            </tbody>
                        </table>
                    </div>


                </div>

            </div>
        </div>
    </div>
    </div>
</x-dashboard.shop>
