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
    
    <livewire:styles />
@endpush

  <div class="container">
        <div class="crad">
            <div class="card-body">
                <h2>
                    Checkout
                </h2>
                <hr>
                <form method="POST" action="{{ route('checkout.store', [request()->user_name, 'payment' => 'company']) }}">
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
                            <div class="form-group">
                                <x-form.countrySelect />
                            </div>
                        </div>
                        <livewire:companysearch />
                        <div class="col-md-12">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="terms" required>
                                <label for="terms" class="form-check-label">Please accept the <a target="_blank" href="https://www.two.inc/buyer-terms-and-conditions-no">terms and condition</a></label>
                            </div>
                        </div>


                        <div class="col-12">
                            <h4>{{ __('words.shipping') }}</h4>
                            <hr>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" data-cost="0" name="shipping" value=""
                                    id="shipping0" checked required />
                                <label class="form-check-label" for="shipping0">Pickup From Store
                                </label>
                            </div>

                            @foreach ($shop->shippings as $shipping)
                                <div class="form-check no-auth">
                                    <input class="form-check-input " name="shipping" type="radio"
                                        value="{{ $shipping->id }}" id="shipping{{ $shipping->id }}" required
                                        data-cost="{{ Iziibuy::onlyPrice($shipping->costWithTax()) }}" />
                                    <label class="form-check-label"
                                        for="shipping{{ $shipping->id }}">{{ $shipping->shipping_method }}
                                        [ {{ Iziibuy::price($shipping->costWithTax()) }} ]</label>
                                </div>
                            @endforeach
                            <hr>
                        </div>
                         <input type="hidden" name="method" value="two">
                        <div class="col-md-6">
                            <div class="form-group">
                                <button class="btn btn-inline" type="submit"> {{ __('words.send_btn') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@push('js')
  <livewire:scripts />
    {{-- <script>
        let country = 'no';
        let companies = [];
        $("select[name='company_country']").change(() => {
            country = $("select[name='company_country']").val();
        })

        $("input[name='company_name']").keydown((e) => {
            searchCompany(e.target.value, country);

            document.getElementById('companies').innerHTML = '';
            companies.map((company) => {
                const option = document.createElement('option');
                option.value = jQuery(company.highlight).text();
                option.id = "data-" + option.value.trim().toLowerCase();
                option.dataset.prefix = company.code;
                option.dataset.number = company.id;
                document.getElementById('companies').appendChild(option);
            })

        });

        $("input[name='company_name']").on('keyup blur keydown', (e) => {

            $("input[name='company_prefix']").val('');
            $("input[name='company_number']").val('');
            $("input[name='company_prefix']").val(document.getElementById(
                `data-${e.target.value.trim().toLowerCase()}`).dataset.prefix);
            $("input[name='company_number']").val(document.getElementById(
                `data-${e.target.value.trim().toLowerCase()}`).dataset.number);
        })

        const searchCompany = (name, country) => {
            let url = '';

            switch (country) {
                case 'no':
                    url = 'https://no.search.two.inc/';
                    break;
                case 'se':
                    url = 'https://se.search.two.inc/';
                    break;
                case 'uk':
                    url = 'https://gb.search.two.inc/';
                    break;
                default:
                    url = 'https://no.search.two.inc/';
                    break;
            }

            fetch(`${url}search?limit=50&offset=0&q=${name}`)
                .then(res => res.json())
                .then(data => {
                    companies = [...data?.data.items]
                });
        }
    </script> --}}
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