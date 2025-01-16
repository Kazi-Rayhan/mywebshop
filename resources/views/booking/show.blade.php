<x-shop-front-end>
@push('style')
    <link rel="stylesheet" href="{{ asset('css/custom/checkout.css') }}">
    <style>
        .single-banner {
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            padding: 100px 0px;
            position: relative;
            z-index: 1;
        }
    </style>
@endpush

    <section class="checkout-part">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="checkout-charge">
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


                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-shop-front-end>
