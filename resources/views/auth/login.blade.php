<x-main>
    <section class="row no-gutters p-0 bg-light min-vh-100 mt-5">
        <div class="col-lg-12">
            <section class="p-0 text-white"
                style="  background: linear-gradient(to top, #1f3763, #355eaa,#1f3763) !important;">

                <div class="container min-vh-lg-100 d-flex flex-column justify-content-between text-center py-4 py-md-5">

                    <a href="index.html" class="fade-page">
                        <img src="assets/img/logos/jumpstart.svg" alt="Jumpstart" data-inject-svg class="bg-white">
                    </a>
                    <div class="row justify-content-center my-5">
                        <div class="col-xl-7 col-lg-8">

                            @if (session()->has('shop_id'))
                                @php
                                    $shop = App\Models\Shop::find(session()->get('shop_id'));
                                @endphp
                                <img src="{{ Iziibuy::image($shop->logo) }}" class="img-fluid mt-5"
                                    style="max-width: 200px">
                            @endif
                            <h1 class="h2 text-center mb-lg-5">{{ __('words.login_sec_title') }}</h1>
                            <div style="border-bottom:2px solid #fff" class="mb-2">
                                <x-language />
                            </div>
                            <div class="card card-body shadow text-left text-dark">
                    
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
                                        type="submit">{{ __('words.login_btn') }}</button>
                                </form>
                            </div>
                            <div class="text-center text-small mt-3">
                                {{ __('words.login_already_reg_msg') }} <a class="text-white"
                                    href="{{ route('register') }}">{{ __('words.log_reg_here_btn') }}</a>
                            </div>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('home') }}"
                            class="btn btn-sm btn-light fade-page">{{ __('words.back_preview_btn') }}</a>
                    </div>
                </div>
            </section>
        </div>
    </section>
</x-main>
