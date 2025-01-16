<x-shop-front-end>
@section('title', $box->title)
@push('style')
    <link rel="stylesheet" href="{{ asset('css/custom/checkout.css') }}">
@endpush


    <section class="">
        <div class="container mt-5">
            <h2>{{ __('words.subscription_box_invoice_sec_title') }}</h2>
            <form action="{{ route('subscription-box-start-subscription', [request()->user_name, $box]) }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mt-2">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <x-form.input type="text" name="first_name" label="{{ __('words.checkout_form_first_name_label') }}"
                                            :value="old('first_name') ?? auth()->user()->name" />
                                    </div>
                                    <div class="col-md-6">
                                        <x-form.input type="text" name="last_name" label="{{ __('words.checkout_form_lastname') }}" :value="old('last_name') ?? auth()->user()->last_name" />
                                    </div>
                                    <div class="col-md-6">
                                        <x-form.input type="email" name="email" label="{{ __('words.checkout_form_email') }}" :value="old('email') ?? auth()->user()->email" />
                                    </div>
                                    <div class="col-md-6">
                                        <x-form.input type="text" name="phone" label="{{ __('words.checkout_form_phone') }}" :value="old('phone') ?? auth()->user()->phone" />
                                    </div>
                                    <div class="col-md-12">
                                        <x-form.input type="text" name="address" label="{{ __('words.invoice_address') }}" :value="old('address') ?? auth()->user()->address" />
                                    </div>
                                    <div class="col-md-4">
                                        <x-form.input type="text" name="city" label="{{ __('words.city') }}" :value="old('city') ?? auth()->user()->city" />
                                    </div>
                                    <div class="col-md-4">
                                        <x-form.input type="text" name="postal_code" label="{{ __('words.invoice_postcode') }} "
                                            :value="old('postal_code') ?? auth()->user()->post_code" />
                                    </div>
                                    <div class="col-md-4">
                                        <x-form.input type="text" name="state" label="{{ __('words.state') }}" :value="old('state') ?? auth()->user()->state" />
                                    </div>
                                </div>


                            </div>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="card mt-2">
                            <div class="card-body table-scroll">
                                <h2>
                                    {{$box->title}}
                                </h2>
                                <h4 class="text-secondary">
                                {{ __('words.subs_create_duration_label') }} - {{@$box->duration->length}} {{@$box->duration->mode}}
                                </h4>
                                <br>
                                <table class='table-list'>
                                    <tr>
                                        <th>
                                            {{ __('words.subscription_esta_cost') }} <br>
                                            <small>(One time)</small>
                                        </th>
                                        <td>
                                            {{ Iziibuy::price($box->est_cost ?? 0)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ __('words.cart_table_price') }}
                                        </th>
                                        <td>
                                            {{  Iziibuy::price($box->price) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            {{ __('words.cart_account_table_title') }}
                                        </th>
                                        <td>
                                            {{  Iziibuy::price($box->price + $box->est_cost) }}
                                        </td>
                                    </tr>
                                </table>
                                <div class="text-center mt-2">
                                    <button type="submit" class="btn btn-danger">
                                      {{__('words.start_running_subs_btn')}}
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </section>
</x-shop-front-end>
