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
        .form-control{
            border: 1px solid #7f6000;
            background-color: transparent;
            color: #000 !important;
        }
        .form-control:focus{
            background-color: transparent;
            outline: 0 none;
            border-color: #7f6000;
        }
      
      

    </style>
@endpush
<section class="mt-5">
    <div class="container border-bottom-1 pb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <form id="regForm" class="shadow p-3 text-dark bg-white p-4" action="{{ route('shop.register.post') }}" method="POST" >
                    @csrf
                    <!-- <h1>Registrering av ny webshop</h1> -->
                    <div class="tab">
                        <h2 class=" section-title-1 text-center">
                          {!! __('words.shop_reg_title') !!} <br> <span class="">{{ __('words.shop_reg_title_2') }}</span>
                            {{-- <span class="">klart på 1-2-3.</span> <br><br> --}}

                        </h2>
                        <p>
                        {!! __('words.shop_reg_sec_pera') !!}
                        <b>{{ __('words.visa') }}</b>, <b>{{ __('words.mastercard') }}</b>, <b>{{ __('words.amex') }}</b> og <b>{{ __('words.vipps') }}</b> {{ __('words.shop_reg_sec_pera_2') }}.
                        </p>
                        <h3 class="section-title-1 text-center">{{ __('words.shop_reg_subtitle') }}</h3>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="email">{{ __('words.checkout_form_email') }}</label>
                                <input id="emailField" class="form-control @error('email') is-invalid @enderror"
                                    name="email" type="email" value="{{ old('email') }}">
                                <span class="invalid-feedback"></span>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">{{ __('words.user_title') }}</label>
                                <input id="emailField" class="form-control @error('title') is-invalid @enderror"
                                    name="title" type="text" value="{{ old('title') }}">
                                <span class="invalid-feedback"></span>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                              <div class="form-group col-md-6">
                                <label for="name">{{ __('words.checkout_form_first_name_label') }}</label>
                                <input id="name" class="form-control @error('name') is-invalid @enderror" name="name"
                                    type="text" autocomplete="on" value="{{ old('name') }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="last_name">{{ __('words.checkout_form_lastname') }}</label>
                                <input id="last_name" class="form-control @error('last_name') is-invalid @enderror"
                                    name="last_name" type="text" value="{{ old('last_name') }}">
                                @error('last_name')
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
                                <label for="company_name">{{ __('words.shop_company_name') }}</label>
                                <input id="company_name"
                                    class="form-control @error('company_name') is-invalid @enderror" name="company_name"
                                    type="text" value="{{ old('company_name') }}">
                                @error('company_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password">{{ __('words.password') }}</label>
                                <input id="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" type="password" />
                                <span class="invalid-feedback"></span>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="passwordConfirmationField">{{ __('words.confirm_pass_label') }}</label>
                                <input id="passwordConfirmationField" class="form-control"
                                    name="password_confirmation" type="password">
                                <span class="invalid-feedback"></span>
                            </div>
                        </div>
                    </div>


                    <button class="btn-home">
                     {{__('words.shop_reg_btn')}}
                    </button>

                </form>
            </div>
        </div>
    </div>
</section>

<div class="bg"></div>







@push('javascript')
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
            document.getElementById("nextBtn").innerHTML = "Send";
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
</x-main>
