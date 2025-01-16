<x-main>
    @push('css')
        <style>
            * {
                font-family: sans-serif;
            }

            body {
                background-color: #f1f1f1;
            }

            #regForm {
                /* background-color: #ffffff; */
                margin: 0px auto;
                border-radius: 15px;

            }

            h1 {
                text-align: center;
            }

            input.invalid {
                background-color: #ffdddd;
            }

            .tab {
                display: none;
                margin-bottom: 20px;
            }

            button {
                background-color: #04AA6D;
                color: #ffffff;
                border: none;
                padding: 10px 20px;
                font-size: 17px;
                font-family: Raleway;
                cursor: pointer;
            }

            button:hover {
                opacity: 0.8;
            }

            #prevBtn {
                background-color: #bbbbbb;
            }

            .step {
                height: 15px;
                width: 15px;
                margin: 0 2px;
                background-color: #bbbbbb;
                border: none;
                border-radius: 50%;
                display: inline-block;
                opacity: 0.5;
            }

            .step.active {
                opacity: 1;
            }

            .step.finish {
                background-color: #04AA6D;
            }

            .shadow {
                box-shadow: 5px 10px gray;
            }

            .shado_bg {
                position: relative;
                z-index: 0;
            }

            .shado_bg::before {
                content: '';
                position: absolute;
                bottom: .2rem;
                left: 0;
                height: 100%;
                width: 100%;
                background: yellow;
                z-index: -1;
                clip-path: polygon(0 90%, 100% 80%, 100% 100%, 0% 100%);
            }

            .bg_blue {
                background: url(images/bg_blue.png);
                background-repeat: no-repeat;
                background-size: contain;
                background-position: bottom;
            }

            .form-control {
                border: 1px solid #7f6000;
                background-color: transparent;
                color: #000 !important;
            }

            .form-control:focus {
                background-color: transparent;
                outline: 0 none;
                border-color: #7f6000;
            }
        </style>
    @endpush
    <div class="container " style="margin-top:150px ">

        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session()->has('shop_id'))
                    @php
                        $shop = App\Models\Shop::find(session()->get('shop_id'));
                    @endphp
                    <div class="text-center mb-3">
                        <img src="{{ Iziibuy::image($shop->logo) }}" class="img-fluid">
                    </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('enterpriseonboarding.register.post') }}">
                            @csrf
                            <h2 class=" section-title-1 text-center">
                                {!! __('words.enterprise_reg_title') !!}
                            </h2>
                            <p class="text-center">
                                {!! __('words.enterprise_reg_sec_pera') !!}
                            </p>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">{{ __('words.checkout_form_first_name_label') }}</label>
                                    <input id="name"class="form-control @error('name') is-invalid @enderror"
                                        name="name" type="text" autocomplete="on" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="last_name">{{ __('words.checkout_form_lastname') }}</label>
                                    <input id="last_name"class="form-control @error('last_name') is-invalid @enderror"
                                        name="last_name" type="text" value="{{ old('last_name') }}">
                                    @error('last_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                             
                                <div class="form-group col-md-6">
                                    <label for="email">{{ __('words.checkout_form_email') }}</label>
                                    <input id="emailField" class="form-control @error('email') is-invalid @enderror""
                                        name="email" type="text" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                          
                                <div class="form-group col-md-6">
                                    <label for="phone">{{ __('words.invoice_tel') }}</label>
                                    <input id="phone" class="form-control @error('phone') is-invalid @enderror"
                                        name="phone" type="text" value="{{ old('phone') }}">
                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                              
                              
                                <div class="form-group col-md-6">
                                    <label for="password">{{ __('words.password') }}</label>
                                    <input id="password" class="form-control @error('password') is-invalid @enderror""
                                        name="password" type="password" />
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="passwordConfirmationField">{{ __('words.forgot_pass') }}</label>
                                    <input id="passwordConfirmationField"
                                        class="form-control"name="password_confirmation" type="password">
                                </div>

                                <div class="form-group col-md-6 mt-5 d-flex">
                                    <button class="btn-home mr-2" type="submit"
                                        autocomplete="on">{{ __('words.register_reg_btn') }}</button>
                                    <a href="{{ route('login') }}"
                                        class="btn btn-outline btn-info">{{ __('words.login_sec_title') }}</a>
                                </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('javascript')
        {{-- <livewire:scripts /> --}}
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"
            integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
            integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
            crossorigin="anonymous"></script>
        @if ($errors->any())
            <script>
                @foreach ($errors->all() as $error)
                    toastr.error('{{ $error }}')
                @endforeach
            </script>
        @endif
        {{-- <script>
        $('#business_fields').hide()
        $('#business_user_check').change((e) => {
            if ($(e.target).is(':checked')) {
                $('#business_fields').show()
            } else {

                $('#business_fields').hide()
            }
        })
    </script> --}}
    @endpush
</x-main>
