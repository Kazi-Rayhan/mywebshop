<x-dashboard.shop>

    @push('styles')
        <style>
            * {
                font-family: sans-serif;
            }

            body {
                background-color: #f1f1f1;
            }

            #regForm {
                background-color: #ffffff;
                margin: 0px auto;

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
        </style>
    @endpush
    <section class="bg_blue">
        <div class="container">
            <div class="row justify-content-center">
               
                <div class="col-md-8">
                    <form id="regForm" class="shadow p-3" action="{{ route('shop.profile.completeProfileUpdate') }}"
                        method="POST">
                        @csrf
                        @method('put')


                        <div class="tab">
                            <h1 class="text-center">{{ __('words.dashboard_complete_reg_title') }}</h1>
                              <p class="bg-success text-light p-2">
                                {{ __('words.dashboard_complete_reg_pera_2') }}</p>
                            {!! __('words.dashboard_complete_reg_pera') !!}
                            <h2>{{ __('words.dashboard_complete_reg_subtitle') }}</h2>
                            <p>
                                {!! __('words.dashboard_complete_reg_subpera') !!} <br>
                                {{ __('words.dashboard_complete_reg_subpera_2') }}
                            </p>
                            <div class="row">

                                <div class="form-group col-md-12">
                                    <label
                                        for="company_registration">{{ __('words.dashboard_complete_reg_form_org_no') }}</label>
                                    <input required id="company_registration"
                                        class="form-control @error('company_registration') is-invalid @enderror"
                                        name="company_registration" type="text"
                                        value="{{ old('company_registration', $shop->company_registration) }}">
                                    @error('company_registration')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label
                                        for="contact_email">{{ __('words.dashboard_complete_reg_form_company_name') }}</label>
                                    <input required id="contact_email"
                                        class="form-control @error('contact_email') is-invalid @enderror"
                                        name="contact_email" type="text"
                                        value="{{ old('contact_email', $shop->contact_email) }}">
                                    @error('contact_email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label
                                        for="contact_phone">{{ __('words.dashboard_complete_reg_form_company_phone') }}</label>
                                    <input required id="contact_phone"
                                        class="form-control @error('contact_phone') is-invalid @enderror"
                                        name="contact_phone" type="text"
                                        value="{{ old('contact_phone', $shop->contact_phone) }}">
                                    @error('contact_phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="form-group">
                                        <label for="country">{{ __('words.invoice_country') }}</label>
                                        <select name="country" id="country" class="form-control">
                                            @foreach (App\Constants\Constants::COUNTRIES as $country)
                                                <option @if ($shop->country == $country) selected @endif>
                                                    {{ $country }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="city">{{ __('words.invoice_place') }}</label>
                                    <input required id="city"
                                        class="form-control @error('city') is-invalid @enderror" name="city"
                                        type="text" value="{{ old('city', $shop->city) }}">
                                    @error('city')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="street">{{ __('words.invoice_address') }}</label>
                                    <input required id="street"
                                        class="form-control @error('street') is-invalid @enderror" name="street"
                                        type="text" value="{{ old('street', $shop->street) }}">
                                    @error('street')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="post_code">{{ __('words.invoice_postcode') }}</label>
                                    <input required id="post_code"
                                        class="form-control @error('post_code') is-invalid @enderror" name="post_code"
                                        type="text" value="{{ old('post_code', $shop->post_code) }}">
                                    @error('post_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>                           
                            </div>
                        </div>





                        <div style="overflow:auto;">
                            <div style="float:right;">
                                <button type="button" id="prevBtn" onclick="nextPrev(-1)">Forrige</button>
                                <button type="button" id="nextBtn" onclick="nextPrev(1)">Neste</button>
                            </div>
                        </div>
                        <div style="text-align:center;margin-top:40px;" class="d-none">
                            <span class="step"></span>
                            <span class="step"></span>
                            <span class="step"></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <div class="bg"></div>


    @push('scripts')
        <script>
            var currentTab = 0;
            showTab(currentTab);

            function showTab(n) {

                var x = document.getElementsByClassName("tab");
                x[n].style.display = "block";

                if (n == 0) {
                    document.getElementById("prevBtn").style.display = "none";
                } else {
                    document.getElementById("prevBtn").style.display = "inline";
                }
                if (n == (x.length - 1)) {
                    document.getElementById("nextBtn").innerHTML = "{{ __('words.send_btn') }}";
                } else {
                    document.getElementById("nextBtn").innerHTML = "Neste";
                }

                fixStepIndicator(n)
            }

            function nextPrev(n) {

                var x = document.getElementsByClassName("tab");

                if (n == 1 && !validateForm()) return false;
                // Hide the current tab:
                x[currentTab].style.display = "none";

                currentTab = currentTab + n;

                if (currentTab >= x.length) {

                    document.getElementById("regForm").submit();
                    return false;
                }

                showTab(currentTab);
            }

            function validateForm() {

                var x, y, i, valid = true;
                x = document.getElementsByClassName("tab");
                y = x[currentTab].getElementsByTagName("input");

                for (i = 0; i < y.length; i++) {
                    // If a field is empty...
                    if (y[i].value == "") {
                        y[i].className += " is-invalid invalid";
                        $(y[i]).next('.invalid-feedback').text('This field is required');
                        valid = false;
                    } else {
                        $(y[i]).removeClass('is-invalid invalid');
                    }
                    if (y[i].type == "email") {
                        if (!validateEmail(y[i].value)) {
                            y[i].className += " is-invalid invalid";
                            $(y[i]).next('.invalid-feedback').text('Please enter a valid email address');
                            valid = false;
                        } else {
                            $(y[i]).removeClass('is-invalid invalid');
                        }
                    }
                    if (y[i].type == "password") {
                        if (y[i].value.length < 8) {
                            y[i].className += " is-invalid invalid";
                            $(y[i]).next('.invalid-feedback').text('Please enter atlest 8 character');
                            valid = false;
                        } else {
                            $(y[i]).removeClass('is-invalid invalid');
                        }
                        if ($('#password').val() != $('#passwordConfirmationField').val()) {
                            y[i].className += " is-invalid invalid";
                            $(y[i]).next('.invalid-feedback').text('Confirm Password Did not match');
                            valid = false;
                        }
                    }


                }
                if (valid) {
                    document.getElementsByClassName("step")[currentTab].className += " finish";
                }
                return valid;
            }
            const validateEmail = (email) => {
                return email.match(
                    /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
                );
            };

            function fixStepIndicator(n) {
                var i, x = document.getElementsByClassName("step");
                for (i = 0; i < x.length; i++) {
                    x[i].className = x[i].className.replace(" active", "");
                }
                x[n].className += " active";
            }
            $('#user_name').keyup(function() {
                var user_name = $(this).val();
                var result = user_name.replace(/\s/g, '').replace(/[^\w\s]/gi, '').toLowerCase();
                $(this).val(result)
            });
        </script>
    @endpush
</x-dashboard.shop>
