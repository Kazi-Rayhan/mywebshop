<div class="row">


    <div class="col-md-6">
        <x-form.input type="text" name="" readonly label="{!! __('words.shop_api_kay') !!}" :value="old('api_key', $user->shop->quickpay_api_key)" />
    </div>
    <div class="col-md-6">
        <x-form.input type="text" name="" readonly label="{!! __('words.shop_secrate_key') !!}" :value="old('secret_key', $user->shop->quickpay_secret_key)" />
    </div>

    @foreach (['elavon_merchant_alias', 'elavon_public_key', 'elavon_secret_key'] as $field)
        <div class="col-md-4">
            <x-form.input type="text" name="" readonly label="{{__('words.'.$field)}}" value="{{$user->shop->$field}}" />
        </div>
    @endforeach
    <div class="col-md-12 ">
        <h6 class="text-secondary">{!! __('words.shop_default_currency') !!}</h6>
        <div class="d-flex border mb-3 rounded">

            @foreach (App\Constants\Constants::ADDITIONAL_CURRENCIES as $currency)
                <div class="form-check m-2">

                    <input class="form-check-input" @if ($user->shop->checkDefaultCurrency($currency)) checked="true" @endif
                        name="default_currency" type="radio" id="default_currency_{{ $currency }}"
                        value="{{ $currency }}">
                    <label class="form-check-label" for="default_currency_{{ $currency }}">
                        {{ $currency }}
                    </label>
                </div>
            @endforeach
        </div>

    </div>

    <div class="col-md-12 ">
        <h6 class="text-secondary">{!! __('words.shop_currencies') !!}</h6>
        <div class="d-flex border mb-3 rounded">
            @foreach (App\Constants\Constants::ADDITIONAL_CURRENCIES as $currency)
                <div class="form-check m-2">

                    <input class="form-check-input" @if ($user->shop->checkCurrency($currency)) checked="true" @endif
                        name="currencies[]" type="checkbox" id="{{ $currency }}-currency"
                        value="{{ $currency }}">
                    <label class="form-check-label" for="{{ $currency }}-currency">
                        {{ $currency }}
                    </label>
                </div>
            @endforeach
        </div>

    </div>
    <div class="col-md-12">
        @php
            $paymentMethods = App\Models\PaymentMethod::all();
        @endphp
        <h5>
            {{ __('words.footer_payment_methods') }}
        </h5>
        @php
            $methodArray = $user->shop->footerPaymentMethod ? json_decode($user->shop->footerPaymentMethod) : [];
        @endphp
        @foreach ($paymentMethods as $item)
            <div class="row row-cols-4 container mb-3">

                <div class="form-check">
                    <input class="form-check-input" name="meta[footerPaymentMethod][]" type="checkbox"
                        @if (in_array($item->id, $methodArray)) checked @endif value="{{ $item->id }}"
                        id="method{{ $item->id }}" />
                    <label class="form-check-label" for="method{{ $item->id }}"> {{ $item->name }} </label>
                </div>
            </div>
        @endforeach
    </div>

</div>
