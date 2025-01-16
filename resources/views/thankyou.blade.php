<x-shop-front-end>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-12 text-center">
                <div class="thanks">
                    <i class="fa fa-check-circle fa-5x" style="color:#49a010"></i>
                    @if ($order->reference != 'self')
                        <h2>{!! __('words.thankyou_title') !!} <br> {{ __('words.thankyou_title_2') }}</h2>
                        <br>
                        <h6>{!! __('words.thankyou_pera') !!} <br>{{ __('words.thankyou_pera_2') }} </h6>
                    @else
                        <h2>{!! __('words.kiosk_thankyou_title') !!}</h2>
                        <br>
                        <h6>{!! __('words.kiosk_thankyou_pera') !!} </h6>
                    @endif
                </div>
            </div>
            @if (request('order'))
                <div class="col-md-6 mt-3">
                    @if ($order->reference != 'self')
                        @if ($order->create_a_account)
                            <h3 class="my-5">
                                {{ __('words.create_a_account') }}
                            </h3>
                        @else
                            <h3 class="my-5">
                                {{ __('words.Please') }} <a class="text-primary"
                                    href="{{ route('register') }}">{{ __('words.login_already_reg_msg') }}</a>
                                {{ __('words.or') }}
                                <a class="text-primary" href="{{ route('login') }}">{{ __('words.login_btn') }}</a>
                                {{ __('words.thankyou_pera2') }}
                            </h3>
                        @endif
                    @else
                        <h3 class="my-5">
                            {{ __('words.kiosk_orderid') }} : {{ $order->id }}
                        </h3>
                    @endif
                    <form action="{{ route('send.order.notification') }}">
                        <input type="hidden" name="order" value="{{ request('order') }}">
                        <div class="input-group mb-3">
                            <input type="email" placeholder="{{ __('words.checkout_form_email') }}" name="email"
                                class="form-control" required>
                            <button class="btn btn-outline-success" type="submit"
                                style="padding: 0.375rem 0.75rem">{{ __('words.thankyou_invoice_btn') }}</button>

                        </div>
                        @if ($order->create_a_account)
                            <i class="fa fa-check text-success"></i> {{ __('words.thankyou_page_guest_signup') }}
                        @endif
                    </form>
                </div>


            @endif
            @if (request('booking'))
                <div class="col-md-6 mt-3">
                    <form action="{{ route('send.order.notification') }}">
                        <input type="hidden" name="booking" value="{{ request('booking') }}">
                        <div class="input-group mb-3">
                            <input type="email" placeholder="{{ __('words.checkout_form_email') }}" name="email"
                                class="form-control" required>
                            <button class="btn btn-outline-success" type="submit"
                                style="padding: 0.375rem 0.75rem">Motta
                                fakturakopi</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>

    </div>
    @push('js')
        @if (Agent::isDesktop() && $shop->hasSelfCheckout())
            <script>
                setTimeout(function() {
                    window.location.href = "{{ route('products', $shop->user_name) }}"
                }, 7000)
            </script>
        @endif
    @endpush
</x-shop-front-end>
