<x-dashboard.shop>
<div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <h4>{{ __('words.service_subscriptio_sec_pera') }} </h4>
                    <ul style="font-size:15px">
                        <li>
                            {{ __('words.service_subs_list_1') }}
                        </li>
                        <li>
                            {{ __('words.service_subs_list_2') }}
                        </li>
                        <li>
                            {{ __('words.service_subs_sec_title_2') }}
                        </li>
                        <li>
                            {{ __('words.service_subs_list_3') }}
                        </li>
                        <li>
                            {{ __('words.service_subs_list_4') }}
                        </li>
                        

                        <h5>
                            <br><br>{{ __('words.service_subscriptio_sec_subtitle') }}
                        </h5>

                        @if (!$shop->service_establishment)
                            <li>
                                {{ $shop->ServiceEstablismentCost() }} {{__('words.service_only_list_1')}}
                            </li>
                        @endif
                        <li>
                            {{ $shop->ServiceMonthlyCost() }} NOK {{ __('words.cart_tax') }}
                        </li>
                        <li>
                            {{ $shop->registrationTax() }} % {{ __('words.invoice_tax') }}
                        </li>
                        <li>
                            {{ __('words.service_only_list_2') }} {{ $shop->ServiceSubscriptionFee() }}
                            NOK
                        </li>
                    </ul>

                    <a href="{{ route('shop.service.subscribe') }}" class="btn btn-primary">
                        {{ __('words.order_btn') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

</x-dashboard.shop>