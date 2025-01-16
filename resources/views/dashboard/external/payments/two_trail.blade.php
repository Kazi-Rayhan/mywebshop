<x-dashboard.external>

    @push('styles')
        <livewire:styles />
    @endpush
    <h3><span class="text-primary opacity-25"><i class="fa fa-credit-card" aria-hidden="true"></i></span>
        {!! __('words.two_payment') !!}
    </h3>

    <div class="container d-flex mt-5 p-2">
        <div class="card w-100 shadow border-rounded border-primary">
            <div class="card-header">
                {!! __('words.two_contract_sec_pera') !!}
            </div>
            @if (session()->has('external_ref_url'))
                <div class="card-body">
                    <div class="card-header">
                        <p class="text-danger">
                            Please visit the link for completing the two regisatration. <a target="_blank"
                                href="{{ session()->get('external_ref_url') }}">{{ session()->get('external_ref_url') }}</a>
                        </p>
                    </div>
                </div>
            @endif
            <div class="card-body">
            <p class="bg-success p-2 text-light">
                {!! __('words.two_contract_massage_sec_subtitle') !!}
            </p>
            <h3>{!! __('words.two_contarct_msg_sec_title') !!}</h3>
            <p>{!! __('words.two_contract_msg_sec_pera') !!}
                <b>({{ __('words.two_contract_msg_sec_pera_2') }})</b> {{ __('words.two_contract_msg_sec_pera_3') }}
            </p>
            </div>
            @if (!auth()->user()->shop->two_form_submited)
                <form action="{{ route('shop.store_setup_payment_two') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div data-step="company_details">
                            <h3>{!! __('words.two_contract_msg_sec_company_details') !!}</h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <x-form.input type='email' name='email' label={!! __('words.email') !!}
                                        :value="old('email', auth()->user()->email)" />
                                </div>
                                <div class="col-md-6">
                                    <x-form.input type='phone' name='phone' label={!! __('words.telephone_number') !!}
                                        :value="old('phone', auth()->user()->phone)" />
                                </div>
                            </div>
                            <livewire:companysearch />
                        </div>
                        <div data-step="payment_details">
                            <h3>{!! __('words.two_contract_msg_sec_payment_details') !!}</h3>
                            <hr>
                            <div class="row">
                                {{-- <div class="col-8 col-md-8">
                            <x-form.input type='number' name='fee_per_order' label='Fee' value='' />
                        </div>
                        <div class="col-4 col-md-4">
                            <div class="form-group">
                                <label for="fee_type">Fee type</label>
                                <select name="fee_type" id="fee_type" class="form-control">
                                    <option>Fixed</option>
                                    <option>Percantage</option>
                                </select>
                            </div>
                        </div> --}}
                                <div class="col-md-6 col-12">
                                    <x-form.input name="name" type="name" label={!! __('words.bank_name') !!}
                                        value="{{ old('name') }}" required />
                                </div>
                                <div class="col-md-6 col-12">
                                    <x-form.input name="bban" type="text" label="BBAN"
                                        value="{{ old('bban') }}" required />
                                </div>

                                <div class="col-md-6 col-12">
                                    <x-form.input name="iban" type="text" label="IBAN"
                                        value="{{ old('iban') }}" required />
                                </div>

                                <div class="col-md-6 col-12">
                                    <x-form.input name="bic" type="text" label="BIC"
                                        value="{{ old('bic') }}" required />
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="country">{!! __('words.checkout_form_company_country') !!}</label>
                                        <select name="country" id="country" class="form-control" required>
                                            @php
                                                $countries = [
                                                    'NO' => 'Norway',
                                                    'SE' => 'Sweden',
                                                    'GB' => 'United Kingdom of Great Britain and Northern Ireland',
                                                    'US' => 'United States of America',
                                                    'NL' => 'Netherlands',
                                                    'ES' => 'Spain',
                                                ];
                                            @endphp
                                            @foreach ($countries as $prefix => $country)
                                                <option value="{{ $prefix }}"
                                                    @if (old('country') == $prefix) selected @endif>
                                                    {{ $country }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div data-step="company_identity">
                            <h3>{!! __('words.two_contract_msg_sec_company_identity') !!}</h3>
                            <hr>
                            <h5>{!! __('words.two_contract_msg_sec_invoice_details') !!}</h5>
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <x-form.input type='email' name='invoice_email' label={!! __('words.two_contract_msg_sec_invoice_email') !!}
                                        :value="old('invoice_email', auth()->user()->email)" />
                                </div>
                                <div class="col-6">
                                    <x-form.input type='tel' name='invoice_phone' label={!! __('words.two_contract_msg_sec_invoice_phone') !!}
                                        :value="old('invoice_phone', auth()->user()->phone)" />
                                </div>

                            </div>
                            <h5>{!! __('words.two_contract_msg_sec_brand_details') !!}</h5>
                            <br>

                            <div class="row">
                                <div class="col-6">
                                    <x-form.input type='text' name='brand_name' label={!! __('words.two_contract_msg_sec_brand_name') !!}
                                        :value="old('brand_name', auth()->user()->shop->name)" />
                                </div>
                                <div class="col-6">
                                    <x-form.input type='url' name='brand_website' label={!! __('words.two_contract_msg_sec_brand_website') !!}
                                        value='' />
                                </div>
                                <div class="col-12">
                                    <x-form.input type='file' name='brand_logo'
                                        label={!! __('words.two_contract_msg_sec_brand_logo') !!} />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="terms" required>
                                    <label for="terms" class="form-check-label">{!! __('words.contract_terms') !!} <a target="_blank"
                                            href="https://www.two.inc/no-merchant-terms">{{ __('words.betingelser') }}</a></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">"{{ __('words.contract_order_btn') }}"</button>
                            </div>
                        </div>
                    </div>
                </form>
            @else
                <div class="card-body">
                    <h4>
                        Your contract
                    </h4>
                    <hr>
                    @if (!auth()->user()->shop->two_merchant_status)
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
                </div>

        </div>
        @endif
    </div>

    @push('scripts')
        <livewire:scripts />
    @endpush

</x-dashboard.external>
