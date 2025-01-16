<?php
use App\Models\Shop;
use Illuminate\Support\Facades\Cache;
$current_shop = Cache::remember('shop-' . request()->user_name, 900, function () {
    return App\Models\Shop::where('user_name', request()->user_name)->first();
});
$default_shop = null;
if (env('enterprise')) {
    $default_shop = Cache::remember('shop-default', 900, function () {
        return App\Models\Shop::where('user_name', env('default_username'))->first();
    });
}

$shop = $default_shop ?? $current_shop;

session()->put('shop_id', $shop->id);
?>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ setting('site.description') }}">
    <meta property="og:url" content="{{ route('shop.home', request('user_name')) }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $shop->name }}" />
    <meta property="og:description" content="{{ setting('site.description') }}" />
    <meta property="og:image" content="{{ Iziibuy::image(setting('site.facebook_image')) }}" />
    <title>@yield('title', $shop->name)</title>

    <link rel="stylesheet" href="{{ asset('fonts/flaticon/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/font-awesome/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendor/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendor/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    @stack('style')
    <style type="text/css">
        .navbar-nav .dropdown-menu {

            position: absolute;
        }


        .navbar-fixed {
            z-index: 90;
            top: 0px !important;
        }

        .table-list tbody tr td {
            padding: 15px 8px !important;
        }

        .table-list thead tr th {
            padding: 15px 8px !important;
        }

        :root {
            --brandcolor: {{ $current_shop->shop_color ? $current_shop->shop_color : '#49a010' }};
            --bottom_color: {{ $current_shop->shop_bottom_color ? $current_shop->shop_bottom_color : ($current_shop->shop_color ? $current_shop->shop_color : '#49a010') }};
            --navbarcolor: {{ $current_shop->header_color ? $current_shop->header_color : '#ddffd5' }};
            --language-text-color: {{ $current_shop->top_header_language_text_color ? $current_shop->top_header_language_text_color : $current_shop->shop_color }};
            --language-hover-color: {{ $current_shop->top_header_language_text_hover_color ? $current_shop->top_header_language_text_hover_color : '#000' }};
            --search-bar-text-color: {{ $current_shop->top_header_search_bar_text_color ? $current_shop->top_header_search_bar_text_color : $current_shop->shop_color }};
            /* --search-bar-hover-color: {{ $current_shop->top_header_search_bar_hover_color ? $current_shop->top_header_search_bar_hover_color : '#fff' }}; */
            --search-bar-bg-color: {{ $current_shop->top_header_search_bar_bg_color ? $current_shop->top_header_search_bar_bg_color : '#fff' }};
            --search-btn-text-color: {{ $current_shop->top_header_search_btn_text_color ? $current_shop->top_header_search_btn_text_color : '#000' }};
            --search-btn-hover-color: {{ $current_shop->top_header_search_btn_hover_color ? $current_shop->top_header_search_btn_hover_color : $current_shop->header_color }};
            --search-btn-bg-color: {{ $current_shop->top_header_search_btn_bg_color ? $current_shop->top_header_search_btn_bg_color : $current_shop->shop_color }};
            --footer-bg-color: {{ $current_shop->footer_bg_color ? $current_shop->footer_bg_color : $current_shop->shop_color }};
            --footer-text-color: {{ $current_shop->footer_text_color ? $current_shop->footer_text_color : '#fff' }};
            --footer-hover-color: {{ $current_shop->footer_text_hover_color ? $current_shop->footer_text_hover_color : $current_shop->header_color }};

            --buy-btn-text-color: {{ $current_shop->buy_btn_text_color ? $current_shop->buy_btn_text_color : '#000' }};
            --buy-btn-hover-color: {{ $current_shop->buy_btn_hover_color ? $current_shop->buy_btn_hover_color : $current_shop->header_color }};
            --buy-btn-bg-color: {{ $current_shop->buy_btn_bg_color ? $current_shop->buy_btn_bg_color : $current_shop->shop_color }};
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'heebo' !important;
        }

        .footer-part {
            background-color: var(--footer-bg-color) !important;
        }

        .footer-bottom {
            padding: 15px 0px;
            background: var(--bottom_color) !important;
        }


        .buy_btn {

            color: var(--buy-btn-text-color) !important;
            border: 1px solid var(--buy-btn-bg-color) !important;
            background-color: var(--buy-btn-bg-color) !important;
        }

        .buy_btn:hover {
            background-color: var(--buy-btn-hover-color) !important;
            color: var(--buy-btn-bg-color) !important;
        }

        .footer-part * {
            color: var(--footer-text-color) !important;
        }

        .footer-part a:hover {
            color: var(--footer-hover-color) !important;
        }

        .language {
            color: var(--language-text-color) !important;
        }

        .language:hover {
            color: var(--language-hover-color) !important;
        }

        .search-bar {
            color: var(--search-bar-text-color) !important;
            transition: .2s ease-in;
            background-color: var(--search-bar-bg-color) !important;
        }

        .search-bar::placeholder {
            color: var(--search-bar-text-color) !important;
        }



        .btn-search {
            color: var(--search-btn-text-color);
            border: 1px solid var(--search-btn-bg-color) !important;
            background-color: var(--search-btn-bg-color) !important;
        }

        .btn-search:hover {
            color: var(--search-btn-text-color);
            border: 1px solid var(--search-btn-bg-color) !important;
            background-color: var(--search-btn-hover-color) !important;
        }

        .top_nav_bar {
            background: {{ $current_shop->shop_color ? $current_shop->shop_color : '#ddffd5' }};
        }

        .navbar-part {
            background: {{ $current_shop->header_color ? $current_shop->header_color : '#ddffd5' }};
        }

        .navbar-part-two {
            background: {{ $current_shop->header_color ? $current_shop->header_color : '#ddffd5' }};
        }

        .navbar-fixed {
            top: 40px;
            !important
        }

        .side_cart_btn {
            right: 41% !important
        }

        .navbar-logo img {
            width: auto !important;
            max-height: 70px;
            max-width: 175px;
        }


        .navbar-link {
            color: {{ $current_shop->menu_color ? $current_shop->menu_color : '#000000' }} !important
        }

        .navbar-link:hover {
            color: {{ $current_shop->menu_hover_color ? $current_shop->menu_hover_color : '#000000' }} !important
        }


        .nav-tabs li .active {
            color: {{ $current_shop->menu_color ? $current_shop->menu_color : '#fff'  }} !important;
            background: var(--navbarcolor) !important;
            border-color: var(--brandcolor) !important;
        }

        #app {
            background: var(--graycolor);
        }

        @media screen and (max-width: 767px) {
            .side_cart_btn {
                right: 75% !important
            }
        }
    </style>

    @yield('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" />
</head>

<body>
    <div id="overlay" class="" onclick="toggleNav()" data-state="on"></div>
    <div id="app" style="display:relative">
        @if (url()->current() != route('checkout', request()->user_name))
            <button onclick="toggleNav()" id="cartbutton" class="btn btn-sm btn-inline p-3">
                <i class="fas   fa-shopping-bag m-0" style="font-size:25px"></i>
                <sup class="badge badge-light"
                    style="font-size:10px">{{ Cart::session(request('user_name'))->getTotalQuantity() }}</sup>

            </button>
        @endif
        <!--=====================================
                    HEADER PART START
        =======================================-->
        <header class="header-part">

            @if (!$shop->hasSelfCheckout())
                <nav class="navbar navbar-expand-lg navbar-expand-sm navbar-expand-xs navbar-light bg-light p-0 pl-2">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="collapse navbar-collapse" style="display: block">
                                    <x-language />
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
            @endif

            <div class="top_header">
                <div class="container ">
                    <div class="row">
                        <div class="col-sm-12 col-md-6 col-lg-6">
                            <ul class="header-info">
                                <li>
                                    <i class="fas fa-envelope"></i>
                                    <p> {{ $shop->contact_email }}</p>
                                </li>
                                <li>
                                    <i class="fas fa-phone-alt"></i>
                                    <p> {{ $shop->contact_phone }}</p>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-12 col-md-6 col-lg-6">

                            <div class="header-option">
                                <div class="header-curr">
                                    <nav
                                        class="navbar navbar-expand-lg navbar-expand-md navbar-expand-sm navbar-expand-xs">
                                        <!-- Right Side Of Navbar -->
                                        <ul class="navbar-nav">
                                            <!-- Authentication Links -->
                                            @if (json_decode($shop->currencies))
                                                <li class="nav-item dropdown">
                                                    <a id="navbarDropdown"
                                                        class="nav-top text-light dropdown-toggle ml-2" href="#"
                                                        role="button" data-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false" v-pre>
                                                        {{ __('words.currency') }}
                                                        ({{ strtoupper(session()->get('current_currency')[request()->user_name] ?? Shop::where('user_name', request()->user_name)->first()->default_currency) }})

                                                        <span class="caret"></span>

                                                    </a>
                                                    @php
                                                        $currencies = json_decode($shop->currencies) ?? ['NOK'];
                                                    @endphp

                                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                                        @foreach ($currencies as $currency)
                                                            <a class="dropdown-item border-bottom"
                                                                href="{{ route('set.currency', ['user_name' => request()->user_name, 'symbol' => $currency]) }}">
                                                                {{ $currency }}
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </li>
                                            @endif

                                            @if (!$shop->hasSelfCheckout())
                                                @guest
                                                    <li class="nav-item dropdown">
                                                        <a id="navbarDropdown" class="nav-top dropdown-toggle ml-2"
                                                            href="#" role="button" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false" v-pre>
                                                            {{ __('words.my_account') }} <span class="caret"></span>
                                                        </a>
                                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                            <a class="dropdown-item border-bottom"
                                                                href="{{ route('login') }}">
                                                                {{ __('words.login_btn') }}
                                                            </a>
                                                            @if (Route::has('register'))
                                                                <a class="dropdown-item border-bottom"
                                                                    href="{{ route('register') }}">
                                                                    {{ __('words.register_reg_btn') }}
                                                                </a>
                                                            @endif
                                                        </div>
                                                    </li>
                                                @else
                                                    <li class="nav-item dropdown">
                                                        <a id="navbarDropdown"
                                                            class="nav-top dropdown-toggle ml-2 text-light" href="#"
                                                            role="button" data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false" v-pre>
                                                            {{ Auth::user()->name }} <span class="caret"></span>
                                                        </a>
                                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                                            @if (auth()->user()->role_id == 3)
                                                                <a class="dropdpaymentMethodsown-item border-bottom"
                                                                    href="{{ route('shop.dashboard') }}">
                                                                    {!! __('words.shop_dashboard_overview') !!}
                                                                </a>
                                                            @endif
                                                            @if (auth()->user()->role_id == 4)
                                                                <a class="dropdown-item border-bottom"
                                                                    href="{{ route('manager.dashboard') }}">
                                                                    {!! __('words.manager_dashboard_overview') !!}
                                                                </a>
                                                            @endif
                                                            <a class="dropdown-item border-bottom"
                                                                href="{{ route('user.dashboard', $shop->user_name) }}">
                                                                {!! __('words.shop_overview') !!}
                                                            </a>
                                                            <a class="dropdown-item border-bottom"
                                                                href="{{ route('user.orders', $shop->user_name) }}">
                                                                {!! __('words.shop_orders') !!}
                                                            </a>
                                                            <a class="dropdown-item border-bottom"
                                                                href="{{ route('logout') }}"
                                                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                                {!! __('words.shop_logout') !!}
                                                            </a>

                                                            <form id="logout-form" action="{{ route('logout') }}"
                                                                method="POST" style="display: none;">
                                                                @csrf
                                                            </form>

                                                        </div>
                                                    </li>
                                                @endguest
                                            @endif
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <nav class="navbar-part">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="navbar-element">
                            <ul class="left-widget">
                                <li><a class="icon icon-inline menu-bar" href="#"><i
                                            class="fas fa-align-left"></i></a>
                                </li>
                            </ul>
                            <a class="navbar-logo"
                                href="{{ request('user_name') == 'tendenz' ? route('home') : route('shop.home', request('user_name')) }}">
                                <img src="{{ Iziibuy::image($current_shop->logo) }}" alt="logo">
                            </a>
                            <form class="search-form navbar-src"
                                action="{{ route('products', request('user_name')) }}" method="get">
                                <input type="text" class="search-bar"
                                    placeholder="{{ __('words.search_placeholder') }}" name="search">
                                <button class="btn btn-inline btn-search">
                                    <i class="fas fa-search"></i>
                                    <span>{{ __('words.search') }}</span>
                                </button>
                            </form>
                            @if (!$shop->hasSelfCheckout())
                                <ul class="right-widget">
                                    <li><a class="icon icon-inline"
                                            href="{{ route('user.dashboard', $shop->user_name) }}"><i
                                                class="fas fa-user"></i></a></li>
                                    <li><a class="icon icon-inline" href="#" onclick="toggleNav()"><i
                                                class="fas fa-shopping-cart mr-1"></i><small>{{ Cart::session(request('user_name'))->getTotalQuantity() }}</small></a>
                                    </li>
                                </ul>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="navbar-slide" style="z-index:102">
                            <div class="navbar-content">
                                <div class="navbar-slide-cross">
                                    <a class="icon icon-inline cross-btn" href="#"><i
                                            class="fas fa-times"></i></a>
                                </div>
                                <form class="search-form mb-4 navbar-slide-src"
                                    action="{{ route('products', request('user_name')) }}" method="get">
                                    <input type="text" name="search" placeholder="{!! __('words.search_placeholder') !!}">
                                    <button class="btn btn-inline">
                                        <i class="fas fa-search"></i>
                                        <span>{!! __('words.search_button') !!}</span>
                                    </button>
                                </form>
                                <ul class="navbar-list">
                                    <li class="navbar-item">
                                        <a class="navbar-link"
                                            href="{{ route('shop.home', request('user_name')) }}"><span>{!! __('words.shop_nav_home') !!}</span></a>
                                    </li>
                                    <li class="navbar-item">
                                        <a class="navbar-link"
                                            href="{{ route('products', request('user_name')) }}"><span>{!! __('words.shop_nav_products') !!}</span></a>
                                    </li>
                                    {{-- @HasSubscription($shop) --}}
                                    @Menu($shop->menus['subscription'])
                                        <li class="navbar-item">
                                            <a class="navbar-link"
                                                href="{{ route('subscription-boxes', request('user_name')) }}"><span>{!! __('words.shop_nav_subscription') !!}</span></a>
                                        </li>
                                    @endMenu
                                    {{-- @endHasSubscription --}}
                                    @CanProvideService($shop)
                                    @Menu($shop->menus['booking'])
                                        <li class="navbar-item">
                                            <a class="navbar-link"
                                                href="{{ route('services', request('user_name')) }}"><span>{!! __('words.shop_nav_booking') !!}</span></a>
                                        </li>
                                    @endMenu
                                    @Menu($shop->menus['pt_booking'])
                                        @HasTrainer($shop)
                                            <li class="navbar-item dropdown">
                                                <a class="navbar-link  dropdown-toggle" href="#" id="navbarDropdown"
                                                    role="button" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    {!! __('words.shop_personal_trainers') !!}
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                    <a class="dropdown-item"
                                                        href="{{ auth()->user()->trainer($shop)->bookingUrl() }}">{{ __('words.book_pt') }}</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('user.booking', [$shop->user_name, 'current' => 'booking']) }}">{{ __('words.calendar') }}</a>
                                                    {{-- <a class="dropdown-item"
                                                        href="{{ route('chat', ['user_name' => request('user_name'),'user' => auth()->user()->trainer($shop)]) }}">{{ __('words.chat') }}</a> --}}
                                                    <a class="dropdown-item"
                                                        href="{{ route('user.pt_trainer', [$shop->user_name, 'current' => 'personal_trainers']) }}">{{ __('words.status') }}</a>
                                                    <a class="dropdown-item"
                                                        href="{{ route('trainer.index', [request('user_name'), auth()->user()->trainer($shop)]) }}">{{ __('words.upgrade') }}</a>
                                                    {{-- <a class="dropdown-item" href="#">{{__('words.invoice')}}</a> --}}

                                                </div>
                                            </li>
                                        @else
                                            <li class="navbar-item">
                                                <a class="navbar-link"
                                                    href="{{ route('trainer.index', request('user_name')) }}"><span>{!! __('words.shop_personal_trainers') !!}</span></a>
                                            </li>
                                        @endHasTrainer
                                    @endMenu
                                    @endCanProvideService
                                    @Menu(url()->current() != route('checkout', request()->user_name))
                                        <li class="navbar-item">
                                            <a class="navbar-link" onclick="toggleNav('mobile')"
                                                href="#"><span>{!! __('words.shop_nav_cart') !!}</span></a>
                                        </li>
                                    @endMenu
                                    @foreach ($shop->links as $link)
                                        @if (@$link->position == 'nav')
                                            <li class="navbar-item"><a class="navbar-link"
                                                    @if (@$link->new_window) target="__blank" @endif
                                                    href="{{ $link->url }}">{{ $link->platform }}</a></li>
                                        @endif
                                    @endforeach
                                    <!-- <li class="navbar-item">
                                        <a class="navbar-link"
                                            href="{{ route('checkout', request('user_name')) }}"><span>{!! __('words.shop_nav_checkout') !!}</span></a>
                                    </li> -->

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        @if (!empty(setting('site.notification')))
            <div class="alert alert-danger text-center" role="alert">
                <p style="font-size:22px">{{ setting('site.notification') }}</p>
            </div>
        @endif
        {{ $slot }}
        <x-cart :shop="$shop" />
    </div>
    @if ($shop->selfcheckout)
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        @if ($shop->hasSelfCheckout())
                            {{ __('words.Deactive_kiosk') }}
                            @else{{ __('words.active_kiosk') }}
                        @endif
                    </h5>
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('active.selfcheckout', $shop->user_name) }}"
                        method="post">
                        @csrf
                        <x-form.input type='pin' name='pin' label="PIN"
                            value='' />
                        <button class="btn btn-outline">
                            @if ($shop->hasSelfCheckout())
                                {{ __('words.Deactive_kiosk') }}
                                @else{{ __('words.active_kiosk') }}
                            @endif
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endif
    <!--=====================================
                     FOOTER PART START
        =======================================-->
    <footer class="footer-part">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="footer-content">
                        <a href="#"><img src="{{ Iziibuy::image($current_shop->logo) }}" alt="logo"></a>
                        <p class="mb-1"> <i class="fa fa-map-marker"></i>
                            {{ $shop->street . ' ' . $shop->post_code . ' ' . $shop->city }}
                        </p>
                        <p class="mb-1"> <i class="fa fa-phone"></i> {{ $shop->contact_phone }} </p>
                        <p class="mb-1"><i class="fa fa-envelope"></i> {{ $shop->contact_email }} </p>

                        @if ($shop->selfcheckout)

                            <br>
                            <button type="button" style="border:none;background:none;color:#0055ff"
                                data-toggle="modal" data-target="#exampleModal">
                                @if ($shop->hasSelfCheckout())
                                    {{ __('words.Deactive_kiosk') }} @else{{ __('words.active_kiosk') }}
                                @endif
                            </button>
                        @endif
                        {{-- <ul class="footer-icon">
                                <li><a class="icon icon-inline" href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a class="icon icon-inline" href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a class="icon icon-inline" href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                <li><a class="icon icon-inline" href="#"><i class="fab fa-instagram"></i></a></li>
                                <li><a class="icon icon-inline" href="#"><i class="fab fa-pinterest-p"></i></a></li>
                            </ul> --}}
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="footer-content">
                        <h3 class="title">{{ __('words.footer_links') }}</h3>
                        <div class="footer-widget">
                            <ul>
                                <li><a
                                        href="{{ route('shop.home', request('user_name')) }}">{!! strip_tags(__('words.shop_nav_home')) !!}</a>
                                </li>
                                <li><a
                                        href="{{ route('user.orders', request('user_name')) }}">{!! strip_tags(__('words.shop_nav_orders')) !!}</a>
                                </li>

                                @foreach ($shop->links as $link)
                                    @if (@$link->position == 'footer' && $link->url)
                                        <li><a href="{{ $link->url }}"
                                                @if (@$link->new_window) target="__blank" @endif>{{ $link->platform }}</a>
                                        </li>
                                    @endif
                                @endforeach

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-4">
                    <div class="footer-content">
                        <h3 class="title">{!! __('words.footer_about_company') !!}</h3>
                        <div>
                            {!! $shop->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--=====================================
                      FOOTER PART END
        =======================================-->


    <!--=====================================
                 FOOTER BOTTOM PART START
        =======================================-->
    <div class="footer-bottom">
        <div class="container">
            <div class="d-flex" style="gap:10px">

                <p>&copy; Alle rettigheter |

                </p>
                <a href="#" data-bs-toggle="modal" data-toggle="modal" data-target="#terms-main">
                    {{ __('words.betingelser') }}
                </a>
                <p>
                    | Digital webshop fra <b>Iziibuy.com</b>

                </p>
            </div>
            <ul class="pay-card">
                @foreach ($paymentMethods as $method)
                    <li><a href="#"><img src="{{ Voyager::image($method->image) }}"
                                alt="{{ $method->name }}"></a></li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="modal fade" id="terms-main" tabindex="10000000" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 750px">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="et_pb_text_inner">
                        <h3>{{ __('words.shop_overview') }}</h3>
                        <p>{{ __('words.terms_pera2') }}
                            {{ route('shop.home', request('user_name')) }}.
                        </p>
                        <p> <strong>{!! __('words.terms_pera') !!}</strong><br>{{ __('words.terms_pera_3') }}
                            ({{ route('shop.home', request('user_name')) }})</p>
                        <p><strong>{{ __('words.terms_pertner_text') }}</strong> </p>
                        <ul class="ml-5" style="list-style: circle">
                            <li><b>{{ __('words.shop_company_name') }}:</b> {{ $shop->company_name }}</li>
                            <li><b>{{ __('words.invoice_address') }}:</b>
                                {{ $shop->street }}</li>
                            <li><b>{{ __('words.invoice_postcode') }}:</b>
                                {{ $shop->post_code . ' ' . $shop->city }}
                            </li>
                            <li><b>{{ __('words.dashboard_complete_reg_form_org_no') }}:</b>
                                {{ $shop->company_registration }}</li>
                            <li><b>{{ __('words.invoice_tel') }}:</b> {{ $shop->contact_phone }}</li>
                            <li><b>{{ __('words.invoice_email') }}:</b> {{ $shop->contact_email }}</li>
                        </ul>
                        {!! $shop->getTranslatedAttribute('terms', app()->getLocale()) !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--=====================================
                 FOOTER BOTTOM PART END
        =======================================-->
    <x-alert />
    <!-- FOR BOOTSTRAP -->
    <script src="{{ asset('js/vendor/jquery-1.12.4.min.js') }}"></script>
    <script src="{{ asset('js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>

    <!-- FOR SLICK SLIDER -->
    <script src="{{ asset('js/vendor/slick.min.js') }}"></script>
    <script src="{{ asset('js/custom/slick.js') }}"></script>

    <!-- FOR COMMON SCRIPT -->
    <script src="{{ asset('js/custom/main.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous"></script>

    @if (session()->has('errors'))
        <script>
            @foreach ($errors->all() as $error)
                toastr.error('{{ $error }}')
            @endforeach
        </script>
    @endif
    @if (session()->has('success'))
        <script>
            toastr.success("{{ session('success') }}")
        </script>
    @endif
    <script>
        function lan(e) {
            var currentUrl = window.location.href;
            var url = new URL(currentUrl);
            url.searchParams.set("lang", e);
            var newUrl = url.href;
            window.location = newUrl;
        }
    </script>
    <script>
        function printDiv(e) {


            var printContents = e.parentNode.previousElementSibling.innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>

    <script>
        var state = ['off', 'on'];
        let overlay = document.getElementById("overlay");

        function toggleNav() {
            let sideNav = document.getElementById("mySidenav")

            if (sideNav.dataset.state == state[0]) {
                sideNav.dataset.state = state[1];
                overlay.classList.add('overlay')
                document.getElementById("cartbutton").classList.add("side_cart_btn");
                $('.navbar-slide').removeClass('active');
            } else {
                sideNav.dataset.state = state[0];
                overlay.classList.remove('overlay')
                document.getElementById("cartbutton").classList.remove("side_cart_btn");
            }

        }

        @if (session()->has('success_msg_cart'))
            toggleNav()
        @endif
    </script>
    @if (session()->has('successKiosk'))
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                title: "{{ __('words.kiosk_welcome_title') }}",
                text: "{{ __('words.kiosk_welcome_subtitle') }}",
                allowOutsideClick: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{ __('words.yes') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    var elem = document.getElementById("app");
                    if (elem.requestFullscreen) {
                        elem.requestFullscreen();
                    } else if (elem.webkitRequestFullscreen) {
                        elem.webkitRequestFullscreen();
                    } else if (elem.msRequestFullscreen) {
                        elem.msRequestFullscreen();
                    }
                }
            })
        </script>
    @endif
    <script>
        const total = parseFloat($('#total').text());
        const updatePrice = () => {
            return $('#total').text((parseFloat($('#shipping_cost').text()) + total).toFixed(2))
        }

        $(document).ready(
            () => {
                $('#shipping_cost').text($("input[name=shipping]:checked").data('cost'));
                shipping = $('#shipping_cost').text()
                updatePrice()
            }
        )

        $("input[name=shipping]").click((e) => {
            $('#shipping_cost').text(e.currentTarget.dataset.cost);
            shipping = $('#shipping_cost').text()
            updatePrice()

        })
    </script>
    <!--=====================================
                    JS LINK PART END
        =======================================-->
    @yield('javascript')
    @stack('js')

</body>


</html>