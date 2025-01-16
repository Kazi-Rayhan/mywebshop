<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', setting('site.title'))</title>
    {{-- <link href="{{ asset('frontend-asset/css/loaders/loader-pulse.css') }}" rel="stylesheet" type="text/css"
        media="all" /> --}}
    <link href="{{ asset('assets/frontend/css/theme.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,400i,600,700&display=swap" rel="stylesheet">
    @stack('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" />
</head>

<body>
    <div>

    </div>
    <div class="navbar-container bg-light">
        <nav class="navbar navbar-expand-lg navbar-light" data-sticky="top">
            <div class="container">


                <a class="navbar-brand navbar-brand-dynamic-color fade-page" href="{{ route('home') }}">
                    @if (setting('site.logo'))
                        <img style="width:150px" src="{{ Iziibuy::image(setting('site.logo')) }}">
                    @else
                        <h4 class="mb-0">{{ setting('site.title') }}</h4>
                    @endif
                </a>
                {{-- <x-language /> --}}
                <div class="d-flex align-items-center order-lg-3">
                    @vendor
                        <a href="{{ route('shop.dashboard') }}"
                            class="btn btn-primary ml-lg-4 mr-3 mr-md-4 mr-lg-0 d-none d-sm-block order-lg-3">{{ __('words.dashboard') }}</a>
                    @else
                        @if (Permission::check('enterprise', 'shop_register'))
                            <a href="{{ route('shop.register') }}"
                                class="btn btn-primary ml-lg-4 mr-3 mr-md-4 mr-lg-0 d-none d-sm-block order-lg-3">{{ __('words.home_hero_sec_btn') }}</a>
                        @endif
                    @endvendor

                    @auth

                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"
                            class="btn btn-danger"> {{ __('words.logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endauth

                    <button aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler"
                        data-target=".navbar-collapse" data-toggle="collapse" type="button">
                        <img alt="Navbar Toggler Open Icon" class="navbar-toggler-open icon icon-sm" data-inject-svg
                            src="{{ asset('frontend-asset/img/icons/interface/icon-menu.svg') }}">
                        <img alt="Navbar Toggler Close Icon" class="navbar-toggler-close icon icon-sm" data-inject-svg
                            src="{{ asset('frontend-asset/img/icons/interface/icon-x.svg') }}">
                    </button>
                </div>
                <div class="collapse navbar-collapse order-3 order-lg-2 justify-content-lg-end" id="navigation-menu">

                    <ul class="navbar-nav my-3 my-lg-0">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-item nav-link">
                                {{ __('words.home') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('about', request()->user_name) }}" class="nav-item nav-link">
                                {{ __('words.about') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('contact', request()->user_name) }}" class="nav-item nav-link">
                                {{ __('words.contact') }}
                            </a>
                        </li>
                        @if (!Auth()->check())
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-item nav-link">
                                    {{ __('words.login_btn') }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    {{ $slot }}

    <footer class="bg-primary-3 text-white links-white pb-4 footer-1">
        <div class="container">
            <div class="row">
                <div class="col-xl-auto mr-xl-5 col-md-3 mb-4 mb-md-0">
                    <h5>{{ __('words.home_footer_col_1_title') }}</h5>
                    <ul class="nav flex-row flex-md-column">
                        <li class="nav-item mr-3 mr-md-0">
                            <a href="/shop/demoshoppen/" target="_blank">{{ __('words.home_footer_col_1_link_1') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="col-xl-auto mr-xl-5 col-md-3">
                    <h5>{{ __('words.home_footer_col_2_title') }}</h5>
                    <ul class="nav flex-row flex-md-column">
                        <li class="nav-item mr-3 mr-md-0">
                            <a href="/page/about"
                                class="nav-link fade-page px-0 py-2">{{ __('words.home_footer_col_2_link_1') }}</a>
                        </li>
                        <li class="nav-item mr-3 mr-md-0">
                            <a href="/contact"
                                class="nav-link fade-page px-0 py-2">{{ __('words.home_footer_col_2_link_2') }}</a>
                        </li>
                        <li class="nav-item mr-3 mr-md-0">
                            <a href="/login"
                                class="nav-link fade-page px-0 py-2">{{ __('words.home_footer_col_2_link_3') }}</a>
                        </li>
                        <li class="nav-item mr-3 mr-md-0">
                            <a href="/register-as-shop"
                                class="nav-link fade-page px-0 py-2">{{ __('words.home_footer_col_2_link_4') }}</a>
                        </li>
                    </ul>
                </div>

                <div class="col-lg mt-2 mt-md-5 mt-lg-0 order-lg-3 order-xl-4">
                    <h5>{{ __('words.home_footer_col_3_title') }}</h5>
                    <div class="card card-body bg-white">
                        <p>{{ __('words.home_footer_col_1_subtitle') }}</p>
                        <form method="post" action="{{ route('newsletter.subscribe') }}">
                            @csrf
                            <div class="d-flex flex-column flex-sm-row form-group">
                                <input class="form-control mr-sm-2 mb-2 mb-sm-0 w-auto flex-grow-1" name="email"
                                    placeholder="{{ __('words.home_footer_email_placeholder') }}" type="email"
                                    required>
                                <button type="submit" class="btn btn-primary btn-loading">

                                    <span>{{ __('words.home_footer_col_3_btn') }}</span>
                                </button>
                            </div>

                            <div class="text-small text-muted">{{ __('words.home_footer_col_3_pera') }}</div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <hr>
                </div>
            </div>
            <div
                class="row flex-column flex-lg-row align-items-center justify-content-center justify-content-lg-between text-center text-lg-left">
                <div class="col-auto">
                    <div class="d-flex flex-column flex-sm-row align-items-center text-small">
                        <div class="text-muted">&copy; 2022 - Alle rettigheter iziibuy.com <a
                                href="https://iziibuy.com/page/betingelser">Betingelser</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </footer>
    <x-alert />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script>
        function lan(e) {
            var currentUrl = window.location.href;
            var url = new URL(currentUrl);
            url.searchParams.set("lang", e);
            var newUrl = url.href;
            window.location = newUrl;
        }
    </script>
    <script type="text/javascript">
        window.addEventListener("load", function() {
            document.querySelector('body').classList.add('loaded');
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous"></script>
    @stack('javascript')
    @if (session()->has('errors'))
    <script>
        var errors = @json(session('errors')->all());

        // Now you can work with the errors array in JavaScript
        for (var i = 0; i < errors.length; i++) {
            toastr.error(errors[i]);
        }
    </script>
@endif
    @if (session()->has('success'))
        <script>
            toastr.success("{{ session('success') }}")
        </script>
    @endif

</body>

</html>
