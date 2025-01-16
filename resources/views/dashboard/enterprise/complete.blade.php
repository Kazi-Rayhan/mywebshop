<x-dashboard.enterprise>
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
                    <form id="regForm" class="shadow p-3" action="{{ route('enterprise.completeProfileStore') }}"
                        method="POST">
                        @csrf



                        <div>
                            <h1 class="text-center">{{ __('words.external_complete_reg_title') }}</h1>
                            {{ __('words.external_complete_reg_details') }}

                            <div class="row">

                                <div class="col-md-12">
                                    <x-form.input type="text" name="company_name"
                                        label="{{ __('words.company_name') }}" :value="old('company_name')" />
                                </div>
                                <div class="col-md-12">
                                    <x-form.input type="email" name="company_email"
                                        label="{{ __('words.company_email') }}" :value="old('company_email')" />
                                </div>
                                <div class="col-md-12">
                                    <x-form.input type="url" placeholder="ex: https://www.example.com"
                                        name="company_domain" label="{{ __('words.company_website_url') }}"
                                        value="https://" :value="old('company_domain')" />
                                </div>

                                <div class="col-md-6">
                                    <x-form.input type="text" placeholder="" name="company_registration"
                                        label="{{ __('words.company_registration') }}" :value="old('company_registration')" />
                                </div>
                                <div class="col-md-6">
                                    <x-form.input type="text" name="company_address[city]"
                                        label="{{ __('words.company_address_city') }}" :value="old('company_address[city]')" />
                                </div>

                                <div class="col-md-6">
                                    <x-form.input type="text" name="company_address[street]"
                                        label="{{ __('words.company_address_street') }}" :value="old('company_address[street]')" />
                                </div>

                                <div class="col-md-6">
                                    <x-form.input type="text" name="company_address[zip]"
                                        label="{{ __('words.company_address_zip') }}" :value="old('company_address[zip]')" />
                                </div>


                            </div>
                        </div>





                        <div style="overflow:auto;">
                            <div style="float:right;">
                                <button type="submit">{{ __('words.submit_btn') }}</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>


</x-dashboard.enterprise>
