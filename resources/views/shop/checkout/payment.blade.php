<x-shop-front-end>
    @push('style')
        <link rel="stylesheet" href="{{ asset('css/card.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/custom/cartlist.css') }}">
    @endpush
    <div class="container my-5">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-success mb-2">{{ __('words.payment_sec_title') }}</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 text-center order-md-1 mb-2">

                <x-qr.direct :size="250" :url="$order->payment_url" :disabled="false" />

            </div>
            <div class="col-md-8 order-md-0 mb-2">
                <div class="cart-totals w-100">
                    <h2 class="title">{{ __('words.payment_sec_subtitle') }}</h2>
                    @if ($order->type == 1)
                        <ul>
                            <li><span>{{ __('words.cart_subtotal') }}
                                </span><span>{{ Iziibuy::withSymbol($order->subtotal - $order->tax,$order->currency) }}</span></li>
                            <li><span>{{ __('words.cart_tax') }} </span><span>{{ Iziibuy::withSymbol($order->tax,$order->currency) }}</span>
                            </li>

                            <li><span>{{ __('words.cart_account_table_title') }}
                                </span><span>{{ Iziibuy::withSymbol($order->total, $order->currency) }}</span></li>
                        </ul>
                    @else
                        <ul>
                            <li><span>{{ __('words.cart_subtotal') }}

                                </span><span>{{ Iziibuy::withSymbol($order->subtotal, $order->currency) }}</span></li>

                            <li><span>{{ __('words.cart_tax') }} </span><span>{{ Iziibuy::withSymbol($order->tax,$order->currency) }}</span>
                            </li>
                            <li><span>{{ __('words.checkout_shipping') }}
                                </span><span>{{ Iziibuy::withSymbol($order->shipping_cost, $order->currency) }}
                                    (With Tax)</span></li>
                            <li><span>{{ __('words.cart_account_table_title') }}
                                </span><span>{{ Iziibuy::withSymbol($order->total, $order->currency) }}</span></li>
                        </ul>
                    @endif
                </div>
            </div>

        </div>
        <div class="row">

            @if ($order->reference != 'self')
                <div class="col-sm-12">
                    <div class="card mb-1">
                        <div class="card-body">
                            <a href="{{ $order->payment_url }}" name="complete-order" id="complete-order"
                                class="btn btn-outline btn-block btn-lg">{{ __('words.orders_pay_btn') }}</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    @push('js')
        <script src="{{ asset('js/app.js') }}"></script>
        @if ($order->shop->hasSelfCheckout())
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                function alertShow() {

                    setTimeout(function() {
                        Swal.fire({
                            title: "{{ __('words.kiosk_message') }}",
                            showDenyButton: true,
                            confirmButtonText: "{{ __('words.yes') }}",
                            denyButtonText: "{{ __('words.cancel_order') }}",
                            html: " {{ __('words.cancel_message') }} <strong></strong> {{ __('words.seconds') }}.<br/><br/>",
                            timer: 20000,
                            didOpen: () => {
                                const content = Swal.getHtmlContainer()
                                const $ = content.querySelector.bind(content)
                                timerInterval = setInterval(() => {
                                    Swal.getHtmlContainer().querySelector('strong')
                                        .textContent = (Swal.getTimerLeft() / 1000)
                                        .toFixed(0)
                                    if ((Swal.getTimerLeft() / 1000) == '0') {
                                        window.location.href =
                                            "{{ route('order.cancel', ['user_name' => request()->user_name, 'order' => $order]) }}"
                                    }
                                }, 100)
                            },
                            willClose: () => {
                                clearInterval(timerInterval)

                            }
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                alertShow()
                            } else if (result.isDenied) {
                                window.location.href =
                                    "{{ route('order.cancel', ['user_name' => request()->user_name, 'order' => $order]) }}"
                            }
                        })
                    }, 60000)
                };
                alertShow();

                let timerInterval
            </script>
            <script>
                const orderId = @json($order->id);
                Echo.channel(`orders.${orderId}`)
                    .listen('PurchaseComplete', (e) => {
                        console.log('asd');
                        window.location.href =
                            "{{ route('thankyou', ['user_name' => Iziibuy::idToUserName($order->shop_id), 'order' => $order]) }}"
                    });
            </script>
        @endif


    @endpush
</x-shop-front-end>
