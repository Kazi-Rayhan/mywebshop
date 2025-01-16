<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="{{ __('voyager::generic.is_rtl') == 'true' ? 'rtl' : 'ltr' }}">

<head>
    <title>@yield('page_title', setting('admin.title') . ' - ' . setting('admin.description'))</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="assets-path" content="{{ route('voyager.voyager_assets') }}" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">

    <!-- Favicon -->
    <?php $admin_favicon = Voyager::setting('admin.icon_image', ''); ?>
    @if ($admin_favicon == '')
        <link rel="shortcut icon" href="{{ voyager_asset('images/logo-icon.png') }}" type="image/png">
    @else
        <link rel="shortcut icon" href="{{ Voyager::image($admin_favicon) }}" type="image/png">
    @endif



    <!-- App CSS -->
    <link rel="stylesheet" href="{{ voyager_asset('css/app.css') }}">

    @yield('css')
    @if (__('voyager::generic.is_rtl') == 'true')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-rtl/3.4.0/css/bootstrap-rtl.css">
        <link rel="stylesheet" href="{{ voyager_asset('css/rtl.css') }}">
    @endif


    <style type="text/css">
        @font-face {
            font-family: arial;
            src: url('fonts/arial.ttf');
        }

        .voyager .side-menu .navbar-header {
            background: {{ config('voyager.primary_color', '#22A7F0') }};
            border-color: {{ config('voyager.primary_color', '#22A7F0') }};
        }

        .widget .btn-primary {
            border-color: {{ config('voyager.primary_color', '#22A7F0') }};
        }

        .widget .btn-primary:focus,
        .widget .btn-primary:hover,
        .widget .btn-primary:active,
        .widget .btn-primary.active,
        .widget .btn-primary:active:focus {
            background: {{ config('voyager.primary_color', '#22A7F0') }};
        }

        .voyager .breadcrumb a {
            color: {{ config('voyager.primary_color', '#22A7F0') }};
        }

        .navbar-fixed-top {
            background: {{ config('voyager.primary_color', '#22A7F0') }} !important
        }

        .voyager .navbar>.container-fluid {
            border: none;
        }

        .hamburger-inner,
        .hamburger-inner::after,
        .hamburger-inner::before {
            background: #fff !important;
        }

        .hamburger.is-active .hamburger-inner:before {
            background: #fff !important
        }

        .voyager .pagination .active>a {
            background: {{ config('voyager.primary_color', '#22A7F0') }};
        }

        .btn-primary {
            background: {{ config('voyager.primary_color', '#22A7F0') }} !important;
        }

        body,
        th,
        td,
        p,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            color: #000 !important;
            font-family: arial;
        }

        .voyager .table>thead>tr>th {
            background: #daeefd;
        }

        .btn-blue {
            background: {{ config('voyager.primary_color', '#22A7F0') }};
            border: 1px solid {{ config('voyager.primary_color', '#22A7F0') }};
            color: #fff
        }

        .btn-add-new {
            background: #1ca083 !important;
        }

        .voyager .side-menu .navbar li.active {
            background: {{ config('voyager.primary_color', '#22A7F0') }};
        }

        .voyager .side-menu.sidebar-inverse .navbar li>a:hover {
            background: {{ config('voyager.primary_color', '#22A7F0') }};
        }

        .voyager .side-menu.sidebar-inverse {
            background: #fff;
        }

        .panel.widget .dimmer {
            background: {{ config('voyager.primary_color', '#22A7F0') }} !important;
        }

        .app-container .side-menu .panel.widget h4 {
            color: #fff !important;
        }

        .text-light {
            color: #fff !important
        }

        .app-container .content-container .side-menu .navbar-nav li.dropdown ul li a {
            color: {{ config('voyager.primary_color', '#22A7F0') }} !important;
            background: #fff
        }

        .app-container .content-container .side-menu .navbar-nav li.dropdown ul li a:hover {
            color: #fff !important;
            background: {{ config('voyager.primary_color', '#22A7F0') }} !important;
        }

        .app-container .content-container .side-menu .navbar-nav li.dropdown ul li.active a {
            color: #fff !important;
            background: {{ config('voyager.primary_color', '#22A7F0') }} !important;
        }

        .form-control {
            font-size: 20px;
            color: #000;
        }
    </style>

    @if (!empty(config('voyager.additional_css')))<!-- Additional CSS -->
        @foreach (config('voyager.additional_css') as $css)
            <link rel="stylesheet" type="text/css" href="{{ asset($css) }}">
        @endforeach
    @endif

    @yield('head')
    <link rel="stylesheet" href="{{ secure_asset('bootstrap-taginput/bootstrap-tag.css') }}">
    @stack('styles');
</head>

<body class="voyager @if (isset($dataType) && isset($dataType->slug)) {{ $dataType->slug }} @endif">

    <div id="voyager-loader">
        <?php $admin_loader_img = Voyager::setting('admin.loader', ''); ?>
        @if ($admin_loader_img == '')
            <img src="{{ voyager_asset('images/logo-icon.png') }}" alt="Voyager Loader">
        @else
            <img src="{{ Voyager::image($admin_loader_img) }}" alt="Voyager Loader">
        @endif
    </div>

    <?php
    if (\Illuminate\Support\Str::startsWith(Auth::user()->avatar, 'http://') || \Illuminate\Support\Str::startsWith(Auth::user()->avatar, 'https://')) {
        $user_avatar = Auth::user()->avatar;
    } else {
        $user_avatar = Voyager::image(Auth::user()->avatar);
    }
    ?>

    <div class="app-container">
        <div class="fadetoblack visible-xs"></div>
        <div class="row content-container">
            @include('voyager::dashboard.navbar')
            @include('voyager::dashboard.sidebar')
            <script>
                (function() {
                    var appContainer = document.querySelector('.app-container'),
                        sidebar = appContainer.querySelector('.side-menu'),
                        navbar = appContainer.querySelector('nav.navbar.navbar-top'),
                        loader = document.getElementById('voyager-loader'),
                        hamburgerMenu = document.querySelector('.hamburger'),
                        sidebarTransition = sidebar.style.transition,
                        navbarTransition = navbar.style.transition,
                        containerTransition = appContainer.style.transition;

                    sidebar.style.WebkitTransition = sidebar.style.MozTransition = sidebar.style.transition =
                        appContainer.style.WebkitTransition = appContainer.style.MozTransition = appContainer.style.transition =
                        navbar.style.WebkitTransition = navbar.style.MozTransition = navbar.style.transition = 'none';

                    if (window.innerWidth > 768 && window.localStorage && window.localStorage['voyager.stickySidebar'] ==
                        'true') {
                        appContainer.className += ' expanded no-animation';
                        loader.style.left = (sidebar.clientWidth / 2) + 'px';
                        hamburgerMenu.className += ' is-active no-animation';
                    }

                    navbar.style.WebkitTransition = navbar.style.MozTransition = navbar.style.transition = navbarTransition;
                    sidebar.style.WebkitTransition = sidebar.style.MozTransition = sidebar.style.transition = sidebarTransition;
                    appContainer.style.WebkitTransition = appContainer.style.MozTransition = appContainer.style.transition =
                        containerTransition;
                })();
            </script>
            <!-- Main Content -->
            <div class="container-fluid">
                <div class="side-body padding-top">
                    @yield('page_header')
                    <div id="voyager-notifications"></div>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @include('voyager::partials.app-footer')

    <!-- Javascript Libs -->


    <script type="text/javascript" src="{{ voyager_asset('js/app.js') }}"></script>

    <script>
        @if (Session::has('alerts'))
            let alerts = {!! json_encode(Session::get('alerts')) !!};
            helpers.displayAlerts(alerts, toastr);
        @endif

        @if (Session::has('message'))

            // TODO: change Controllers to use AlertsMessages trait... then remove this
            var alertType = {!! json_encode(Session::get('alert-type', 'info')) !!};
            var alertMessage = {!! json_encode(Session::get('message')) !!};
            var alerter = toastr[alertType];

            if (alerter) {
                alerter(alertMessage);
            } else {
                toastr.error("toastr alert-type " + alertType + " is unknown");
            }
        @endif
    </script>
    @include('voyager::media.manager')
    @yield('javascript')
    @stack('javascript')
    @if (!empty(config('voyager.additional_js')))<!-- Additional Javascript -->
        @foreach (config('voyager.additional_js') as $js)
            <script type="text/javascript" src="{{ asset($js) }}"></script>
        @endforeach
    @endif
    <script src="{{ secure_asset('bootstrap-taginput/bootstrap-tag.js') }}"></script>
</body>

</html>
