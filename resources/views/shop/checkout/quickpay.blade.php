<x-shop-front-end>

    @push('style')
        <link rel="stylesheet" href="{{ asset('css/custom/checkout.css') }}">
    @endpush
    <section class="checkout-part">
        <div class="container">

            @auth
                <div class="row">
                    @guest
                        <div class="col-lg-12">
                            <div class="checkout-action">
                                <i class="fas fa-external-link-alt"></i>
                                <span>{{ __('words.returning_customer_text') }} <a
                                        href="{{ route('login') }}">{{ __('words.checkout_login_btn') }}</a></span>
                            </div>
                        </div>
                    @endguest
                    <div class="col-lg-12">
                        <div class="check-form-title">
                            <h3>{!! strip_tags(__('words.checout_sec_title')) !!}</h3>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-header">
                                {{ auth()->user()->name . ' ' . auth()->user()->last_name }}
                            </div>
                            <div class="card-body">
                                {{ auth()->user()->address }} <br>
                                {{ auth()->user()->post_code . ' ' . auth()->user()->city . ' ' . auth()->user()->state }}
                                <br>
                                <form action="{{ route('checkout.store', request('user_name')) }}" method="post">
                                    @csrf
                                    <div class="my-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" data-cost="00.00" name="shipping"
                                                value="" id="shipping0" required />
                                            <label class="form-check-label" for="shipping0">Pickup From Store
                                            </label>
                                        </div>

                                        @foreach ($shop->shippings as $shipping)
                                            <div class="form-check">
                                                <input class="form-check-input" name="shipping" type="radio"
                                                    value="{{ $shipping->id }}"
                                                    @if (session()->get('shipping') == $shipping->id) checked @endif
                                                    id="shipping{{ $shipping->id }}"
                                                    data-cost="{{ Iziibuy::onlyPrice($shipping->costWithTax()) }}"
                                                    required />
                                                <label class="form-check-label"
                                                    for="shipping{{ $shipping->id }}">{{ $shipping->shipping_method }}
                                                    [ {{ Iziibuy::price($shipping->costWithTax()) }} ]</label>
                                            </div>
                                        @endforeach

                                    </div>
                                    <button type="button" class="btn btn-success p-1 btn-sm float-right"
                                        data-toggle="modal" data-target=".profile">Endre/ legg til kundedetaljer</button>
                            </div>
                            <div class="card-footer">
                                <input type="checkbox" class="mt-5" required @auth checked @endauth>
                                {!! __('words.terms') !!} <a href="" data-toggle="modal" data-target="#terms">
                                    {{ __('words.terms_2') }}</a> <br>
                                <button type="submit" class="btn btn-success">Kjøp!</button>
                                </form>
                            </div>
                            </form>
                        </div>
                    </div>


                </div>
            @else
                <form action="{{ route('checkout.store', request('user_name')) }}" method="post">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <x-form.input type="text" name="first_name" label="{!! strip_tags(__('words.checkout_form_first_name_label')) !!}" :value="old('first_name')"
                                required />
                        </div>
                        <div class="col-md-6">
                            <x-form.input type="text" name="last_name" label="{!! strip_tags(__('words.checkout_form_lastname')) !!}" :value="old('last_name')"
                                required />
                        </div>
                        <div class="col-md-6">
                            <x-form.input type="email" name="email" label="{!! strip_tags(__('words.checkout_form_email')) !!}" :value="old('email')"
                                required />
                        </div>
                        <div class="col-md-6">
                            <x-form.input type="text" name="phone" label="{!! strip_tags(__('words.checkout_form_phone')) !!}" :value="old('phone')"
                                required />
                        </div>

                        <div class="col-md-12">
                            <div class="row" id="extra-field">
                                <div class="col-md-12">
                                    <x-form.input type="text" name="address" label="{!! strip_tags(__('words.invoice_address')) !!}"
                                        :value="old('address')" />

                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="country">{{ __('words.invoice_country') }}</label>
                                        <select name="country" id="country" class="form-control">
                                            @foreach (App\Constants\Constants::COUNTRIES as $country)
                                                @if (old('country') == $country)
                                                    <option selected>{{ $country }}</option>
                                                @else
                                                    <option>{{ $country }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('country')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <x-form.input type="text" name="city" label="{!! strip_tags(__('words.invoice_place')) !!}"
                                        :value="old('city')" />

                                </div>
                                <div class="col-md-6">
                                    <x-form.input type="text" name="post_code" label="{!! strip_tags(__('words.invoice_postcode')) !!}"
                                        :value="old('post_code')" />

                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="my-3">
                        <h4>{!! strip_tags(__('words.shipping_method')) !!}</h4>
                        <hr>

                        @if ($shop->store_as_pickup_point)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="shipping" value=""
                                    @if (!old('shipping')) checked @endif id="shipping0" required
                                    data-cost="0" />
                                <label class="form-check-label" for="shipping0">{!! strip_tags(__('words.pickup_from_store')) !!}
                                </label>
                            </div>
                        @endif
                        @foreach ($shop->shippings as $shipping)
                            <div class="form-check no-auth">
                                <input class="form-check-input " name="shipping" type="radio"
                                    @if (old('shipping') == $shipping->id || session()->get('shipping') == $shipping->id) checked @endif value="{{ $shipping->id }}"
                                    id="shipping{{ $shipping->id }}" required
                                    data-cost="{{ Iziibuy::onlyPrice($shipping->costWithTax()) }}" />
                                <label class="form-check-label"
                                    for="shipping{{ $shipping->id }}">{{ $shipping->shipping_method }}
                                    [ {{ Iziibuy::price($shipping->costWithTax()) }} ]</label>
                            </div>
                        @endforeach
                        <input type="checkbox" class="mt-5" required  />
                        {!! __('words.terms') !!}        <a href="#" data-bs-toggle="modal" data-toggle="modal" data-target="#terms-main">
                        {{ __('words.betingelser') }}
                    </a>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-inline" type="submit"> {{ __('words.checkout_order_btn') }}</button>
                    </div>
                </form>
            @endauth
            @if (Cart::getTotalQuantity() > 0)
                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="check-form-title">
                            <h3>{{ __('words.checkout_confirm_order') }}</h3>
                        </div>
                        <div class="table-scroll">
                            <table class="table-list">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ __('words.cart_table_product') }}</th>
                                        <th scope="col">{!! strip_tags(__('words.cart_table_price')) !!}</th>
                                        <th scope="col">{!! strip_tags(__('words.cart_table_number')) !!}</th>
                                        <th scope="col">{!! strip_tags(__('words.cart_table_action')) !!}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (Cart::session(request('user_name'))->getContent() as $product)
                                        <tr>
                                            <td>
                                                <a href="{{ $product->model->path() }}"
                                                    class="text-secondary">{{ $product->model->name }}</a> <br />
                                                @if ($product->model->variation)
                                                    {{ json_encode($product->model->variation) }}
                                                @endif
                                            </td>
                                            <td>{{ Iziibuy::price($product->price) }}</td>
                                            <td>
                                                <form action="{{ route('cart.update', request('user_name')) }}"
                                                    method="post">
                                                    @csrf
                                                    <input type="hidden" name="product_id"
                                                        value="{{ $product->id }}" />
                                                    <div class="input-group mb-3">
                                                        <input name="quantity" class="form-control" min="1"
                                                            step="1" type="number"
                                                            value="{{ $product->quantity }}" style="width:50px">
                                                        <div class="input-group-append">
                                                            <input type="submit" class="btn btn-inline py-0 px-2"
                                                                value="{!! strip_tags(__('words.cart_table_update_btn')) !!}">
                                                        </div>
                                                    </div>
                                                </form>
                                            </td>
                                            <td class="table-action">
                                                <a
                                                    href="{{ route('cart.destroy', ['id' => $product->id, 'user_name' => request('user_name')]) }}"><i
                                                        class="fas fa-trash-alt"></i></a>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="checkout-charge">
                        <ul>
                            <li><span>{!! strip_tags(__('words.cart_subtotal')) !!}</span><span>{{ Iziibuy::price(Iziibuy::basePrice()) }}</span>
                            </li>
                            <li><span>{!! strip_tags(__('words.cart_tax')) !!}</span><span>{{ Iziibuy::price(Iziibuy::tax()) }}</span>
                            </li>
                            <li><span>{!! __('words.checkout_shipping') !!}</span> <span class="d-flex"><span class="mr-3"
                                        id="shipping_cost">0
                                    </span><span>{{ session()->get('current_currency')[request()->user_name] ?? $shop->default_currency }}
                                        (With Tax)</span></span>
                            </li>
                            @if (Iziibuy::discount() > 0)
                                <li><span>{!! strip_tags(__('words.cart_discount')) !!} <a
                                            href="{{ route('coupon.destroy', request('user_name')) }}"> ( Remove
                                            )</a></span><span>{{ Iziibuy::price(Iziibuy::discount()) }}</span></li>
                            @endif
                            <li><span>{!! strip_tags(__('words.cart_account_table_title')) !!}</span>
                                <span class="d-flex"> <span id="total"
                                        class="mr-3">{{ Iziibuy::onlyPrice(Iziibuy::newSubtotal()) }}</span>
                                    <span>{{ session()->get('current_currency')[request()->user_name] ?? $shop->default_currency }}</span>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @auth
        <div class="modal fade profile" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('words.retailer_profile_sec_title') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ route('user.update', request()->user_name) }}">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name">{{ __('words.checkout_form_first_name_label') }}</label>
                                        <input value="{{ Auth::user()->name }}" type="text"
                                            class="form-control @error('name') is-invalid @enderror" id="name"
                                            placeholder="{{ __('words.checkout_form_first_name_label') }}" name="name"
                                            required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="last_name">{{ __('words.checkout_form_lastname') }}</label>
                                        <input value="{{ Auth::user()->last_name }}" type="text"
                                            class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                                            placeholder="{{ __('words.checkout_form_lastname') }}" name="last_name"
                                            required>
                                        @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">{{ __('words.checkout_form_email') }}</label>
                                        <input value="{{ Auth::user()->email }}" type="text" class="form-control"
                                            id="email" placeholder="{{ __('words.checkout_form_email') }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="phone">{{ __('words.checkout_form_phone') }}</label>
                                        <input value="{{ Auth::user()->phone }}" type="text" class="form-control"
                                            id="phone" name="phone"
                                            placeholder="{{ __('words.checkout_form_phone') }}" required>
                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">{{ __('words.invoice_address') }}</label>
                                        <input value="{{ Auth::user()->address }}" type="text"
                                            class="form-control @error('address') is-invalid @enderror" id="address"
                                            placeholder="{{ __('words.invoice_address') }}" name="address">
                                        @error('address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="country">{{ __('words.invoice_country') }}</label>
                                        <select name="country" id="country" class="form-control">
                                            @foreach (App\Constants\Constants::COUNTRIES as $country)
                                                <option @if ($country == auth()->user()->country) selected @endif>
                                                    {{ $country }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('country')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="state">{{ __('words.invoice_state') }}</label>
                                        <input value="{{ old('state', Auth::user()->state) }}" type="text"
                                            class="form-control @error('state') is-invalid @enderror" id="state"
                                            placeholder="{{ __('words.invoice_state') }}" name="state">
                                        @error('state')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="city">{{ __('words.invoice_place') }}</label>
                                        <input value="{{ Auth::user()->city }}" type="text"
                                            class="form-control @error('city') is-invalid @enderror" id="city"
                                            placeholder="Sted" name="city">
                                        @error('city')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="post_code">{{ __('words.invoice_postcode') }}</label>
                                        <input value="{{ Auth::user()->post_code }}" type="number" step="1"
                                            class="form-control @error('post_code') is-invalid @enderror" id="post_code"
                                            placeholder="Postnummer" name="post_code">
                                        @error('post_code')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button class="btn btn-inline" type="submit">
                                            {{ __('words.send_btn') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="modal fade" id="staticBackdrop" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-body ">
                        <div class="mx-auto">

                            <h5 class="modal-title mb-2" id="exampleModalLongTitle">{{ __('words.login_sec_title') }}
                            </h5>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <input placeholder="{{ __('words.checkout_form_email') }}" id="email"
                                        type="text" class="form-control @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email"
                                        autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <input placeholder="{{ __('words.password') }}" id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="text-right text-small mt-2">
                                        <a href="{{ route('register') }}"
                                            class="mr-3">{{ __('words.login_already_reg_msg') }}</a>
                                        <a
                                            href="{{ route('password.request') }}">{{ __('words.forgot_password_label') }}</a>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox text-small">
                                        <input type="checkbox" class="custom-control-input" id="sign-in-remember">
                                        <label class="custom-control-label"
                                            for="sign-in-remember">{{ __('words.login_remember_me_label') }}</label>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-block"
                                    type="submit">{{ __('words.login_sec_title') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endauth
    @push('js')
        <script>
            @if (!session()->has('shipping'))
                $($("input[name='shipping']")[0]).prop("checked", true);
            @endif
            $("#extra-field").hide();

            if ($("input[name='shipping']:checked").val()) {
                $("#extra-field").show();
                $('#post_code,#city,#address,#state,#country').prop('required', true);
            }


            $('input[name=shipping]').each((index, el) => {
                $(el).click((e) => {
                    if ($(e.target).val()) {
                        $("#extra-field").show();
                        $('#post_code,#city,#address,#state,#country').prop('required', true);
                    } else {
                        $("#extra-field").hide();
                        $('#post_code,#city,#address,#state').prop('required', false);

                    }
                })
            })


            let shipping = 0;
            $('#staticBackdrop').on('hide.bs.modal', function() {
                $('#shipping_cost').text(0);
                updatePrice()

                @if (!session()->has('shipping'))
                    $("input[id=shipping0]").prop("checked", true)
                @endif

            })
        </script>

        <script>
            const checkShipping = (data) => {

                if (!data) {
                    toastr.error(
                        'Shipping method is not avaliable in you country . Change your country or choose another shipping option'
                    );
                }
            }
            $("input[name='shipping']").click(e => {
                if (e.target.checked) {
                    fetch("{{ url('/check-shipping') }}?shipping=" + e.target.value)
                        .then((response) => response.json())
                        .then((data) => checkShipping(data));

                }
            })
        </script>
    @endpush
</x-shop-front-end>
