<x-dashboard.shop>

    <h3><span class="text-primary opacity-25">{!! __('words.contrtact_sec_title') !!} </span> {{ __('words.dashboard') }}</h3>
    <div class="row mt-3">
        @if (auth()->user()->shop->contract_signed == 0)
            <div class="col-lg-12">
                <div class="card ">
                    <div class="card-header">
                        {!! __('words.contract_sec_pera') !!}
                    </div>
                    <div class="card-body">
                        <p class="bg-success p-2 text-light">
                            {!! __('words.contract_massage_sec_subtitle') !!}
                        </p>
                        <h3>{!! __('words.contarct_msg_sec_title') !!}</h3>
                        <p>{!! __('words.contract_msg_sec_pera') !!}
                            {{ __('words.contract_msg_sec_pera_3') }}
                        </p>


                            <form action="{{ route('shop.post.complete.signup') }}" method="post">
                                @csrf

                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="visa" value="Visa"
                                            id="visa" checked>
                                        <label class="form-check-label" for="visa">
                                            Visa
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="mastercard"
                                            value="Mastercard" id="Mastercard" checked>
                                        <label class="form-check-label" for="Mastercard">
                                            Mastercard
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="amex"
                                            value="amex" id="amex" checked>
                                        <label class="form-check-label" for="amex">
                                            Amex
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="vipps" value="Vipps"
                                            id="Vipps" >
                                        <label class="form-check-label" for="Vipps">
                                            Vipps
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="B2B" value="B2B"
                                            id="B2B">
                                        <label class="form-check-label" for="B2B">
                                            B2B
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">{!! __('words.contract_order_btn') !!}</button>
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="terms" value="terms"
                                            id="terms" checked>
                                        <label class="form-check-label" for="terms">
                                            {!! __('words.contract_terms') !!}
                                            <a
                                                href="https://iziibuy.com/page/betingelser">{{ __('words.betingelser') }}</a>
                                        </label>
                                    </div>
                                    <p>{!! __('words.contract_footer') !!} </p>
                                </div>

                            </form>
                      
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('words.contract') }}
                    </div>
                    <div class="card-body">
                        @if (auth()->user()->shop->contract_status == 0)
                            <p>
                            <h1>{!! __('words.contract_has_panding') !!} </h1>
                            </p>
                            <p>{{ __('words.contract_has_panding_pera_2') }} </p>
                            <div class="btn btn-danger">{{ __('words.contract_has_panding_pera_3') }}</div>
                        @else
                            <p>
                            <h1> {!! __('words.contract_has_panding') !!} </h1>
                            </p>
                            <p> {!! __('words.contract_has_submit') !!} </p>
                            <div class="btn btn-success">{{ __('words.contract_has_submit_2') }}</div>
                        @endif

                        @if (auth()->user()->shop->contract_url || auth()->user()->shop->contract_status)
                            <div class="card mt-5">
                                <div class="card-body">
                                    <div class="row">
                                        <div
                                            class=" mb-2 col-12 col-md-6 d-flex flex-column justify-content-center align-items-start">
                                            <div class="w-100">
                                                <h2 class="ml-5 rounded-circle bg-dark text-light d-flex justify-content-center align-items-center"
                                                    style="height:50px;width:50px">
                                                    1
                                                </h2>
                                                <div class="text-left">
                                                    {{-- Sign your digital contract online --}}
                                                    <h3>{{ __('words.sign_contract_title') }}</h3>
                                                    {{-- It's fast and only take 2 miniutes --}}
                                                    <h6>{{ __('words.sign_contract_sub_title') }}</h6>
                                                </div>
                                            </div>


                                        </div>
                                        <div
                                            class="col-12 col-md-6 d-flex flex-column justify-content-center align-items-center">

                                            <a class="btn btn-success btn-block w-50 mb-1" target="_blank"
                                                href="{{ auth()->user()->shop->contract_url ? auth()->user()->shop->contract_url : 'javascript:void(0)' }}">{{ __('words.contract') }}</a>
                                            <div
                                                class="{{ auth()->user()->shop->contract_status ? 'border border-success text-success p-1 w-50 text-center' : 'bg-dark text-light p-1 w-50 text-center' }}">
                                                {{ auth()->user()->shop->contract_status ? __('words.approved') : __('words.sign_contract_button') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div
                                            class=" mb-2 col-12 col-md-6 d-flex flex-column justify-content-center align-items-start">
                                            <div class="w-100 ">
                                                <h2 class="ml-5 rounded-circle bg-dark text-light d-flex justify-content-center align-items-center"
                                                    style="height:50px;width:50px">
                                                    2
                                                </h2>

                                                <div class="text-left">
                                                    {{-- Know your customer (KYC) --}}
                                                    <h3>{{ __('words.sign_kyc_title') }}</h3>
                                                    {{-- We need to know you better, Security for you and your clients --}}
                                                    <h6>{{ __('words.sign_kyc_sub_title') }}</h6>
                                                </div>
                                            </div>


                                        </div>
                                        <div
                                            class="col-12 col-md-6 d-flex flex-column justify-content-center align-items-center">

                                            <a class="btn btn-success btn-block w-50 mb-1" target="_blank"
                                                href="{{ auth()->user()->shop->kyc_status ? 'javascript:void(0)' : 'https://submit.anyday.io/iziibuy-kyc?shopid=' . auth()->user()->shop->id }}">{{ __('words.kyc') }}</a>
                                            <div
                                                class="{{ auth()->user()->shop->kyc_status ? 'border border-success text-success p-1 w-50 text-center' : 'bg-dark text-light p-1 w-50 text-center' }}">
                                                {{ auth()->user()->shop->kyc_status ? __('words.approved') : __('words.sign_kyc_button') }}
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-dashboard.shop>
