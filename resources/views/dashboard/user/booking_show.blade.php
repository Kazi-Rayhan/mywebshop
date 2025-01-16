<x-dashboard.user>
    @push('style')
        <link rel="stylesheet" href="{{ asset('css/custom/checkout.css') }}">
    @endpush
    <section class="checkout-part">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="checkout-charge ">
                        <ul>
                            <li>
                                <span>{{ __('words.service') }} {{ __('words.dashboard_category_index_name') }}</span>
                                <span>{{ $booking->service->name }}</span>
                            </li>
                            <li>
                                <span>{{ __('words.dashboard_managers') }}</span>
                                <span>{{ $booking->manager->full_name }}</span>
                            </li>
                            <li>
                                <span>{{ __('words.cart_table_price') }}</span>
                                <span>{{ $booking->service->priceFormated($booking->manager) }}</span>
                            </li>
                            <li>
                                <span>{{ __('words.appointment') }} {{ __('words.charge_at') }}</span>
                                <span>
                                    {{ $booking->start_at->format('M d, Y') }} at
                                    {{ $booking->start_at->format('h:ia') }} -
                                    {{ $booking->end_at->format('h:ia') }}

                                </span>
                            </li>
                            <li>
                                <span>{{ __('words.dashboard_status') }}</span>
                                <span>
                                    {{ $booking->status }}

                                </span>
                            </li>
                            <li>
                                <span>{{ __('words.payment_status') }}</span>
                                <span>
                                    {{ $booking->payment_status }}

                                </span>
                            </li>
                            @if ($booking->payment_status == 'Unpaid')
                                <li>
                                    @if ($booking->payment_url)
                                        <a class="btn btn-success"
                                            href="{{ $booking->payment_url }}">{{ __('words.orders_pay_btn') }}</a>
                                    @else
                                        <a class="btn btn-success"
                                            href="{{ route('booking.pay', ['user_name' => request('user_name'), 'booking' => $booking]) }}">{{ __('words.orders_pay_btn') }}</a>
                                    @endif
                                </li>
                            @endif
                            <a class="btn btn-primary-outline my-4 float-right"
                                href="{{ route('user.booking', request()->user_name) }}"> <i
                                    class="fa fa-arrow-left"></i> {{ __('words.booking') }}</a>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </section>

</x-dashboard.user>
