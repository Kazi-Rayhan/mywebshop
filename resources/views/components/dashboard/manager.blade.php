<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>{{ env('APP_NAME') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
        integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
    <script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js"
        integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/style.css') }}">
    <meta name="robots" content="noindex, follow">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script defer src="https://unpkg.com/alpinejs@3.9.5/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    @stack('styles')
    <style>
        .delete-icon {
            position: absolute;
            top: -10px;
            background: #f0e5e5;
            padding: 2px 2px;
            line-height: 12px;
            border-radius: 19%;
        }

        .shop_details {
            font-size: 16px !important;
            border-bottom: 2px solid #000;
            padding-bottom: 5px
        }

        .customer_details {
            line-height: 1px !important;
            margin-bottom: 2px
        }
    </style>
</head>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar" class="d-print-none">
            <div class="custom-menu">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
            </div>
            <div class="p-4">

                <h4><a href="#" class="logo text-light">{{ auth()->user()->getShop()->name }} </a></h4>
                <ul class="list-unstyled components mb-5 d-print-none">




                    <x-dashboard.nav.item :link="route('manager.dashboard')" :title="__('words.dashboard')" id="dashboard" icon="fa-tachometer-alt"
                        :active="true" />
                    <x-dashboard.nav.item :link="route('manager.products')" :title="__('words.products_sec_title')" id="products" icon="fas fa-shopping-cart"
                        :active="Permission::check('product', 'browse')" />

                    <x-dashboard.nav.item :link="route('manager.order.index')" :title="__('words.shop_orders')" id="orders"
                        icon="fas fa-cash-register mr-3" :active="auth()->user()->view_orders == '1'" />
                    <x-dashboard.nav.item :link="route('manager.availability.create')" :title="__('words.available')" id="availability"
                        icon="fas fa-calendar-alt" :active="Permission::check('booking', 'browse')" />
                    <x-dashboard.nav.item :link="route('manager.booking.index')" :title="__('words.shop_nav_booking')" id="booking" icon="fas fa-tags"
                        :active="Permission::check('booking', 'browse') ||
                            Permission::check('personal_trainee', 'browse')" />
                    @if (auth()->user()->getShop()->can_provide_service)
                        <x-dashboard.nav.item :link="route('manager.booking.callender')" :title="strip_tags(__('words.calender_sec_title'))" id="callender"
                            icon="far fa-calendar-alt" :active="Permission::check('booking', 'browse') ||
                                Permission::check('personal_trainee', 'browse')" />
                    @endif
                    <x-dashboard.nav.item :link="route('manager.booking.client.index')" :title="strip_tags(__('words.clients'))" id="clientIndex" icon="fas fa-users"
                        :active="Permission::check('personal_trainee', 'browse')" />
                    <x-dashboard.nav.item :link="route('manager.commisssions.index')" :title="strip_tags(__('words.commissions'))" id="clientIndex"
                        icon="fas fa-percentage" :active="Permission::check('personal_trainee', 'browse')" />
                    <x-dashboard.nav.item :link="route('manager.report')" :title="strip_tags(__('words.reports_sec_title'))" id="report" icon="fas fa-cart-plus"
                        :active="Permission::check('personal_trainee', 'browse')" />
                    <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
                            <span class="fas fa-toggle-off mr-3"></span>{{ __('words.logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                    <x-language5 />
                    <div class="footer mt-5">
                        <p>
                            {!! __('words.copy_write_msg_1') !!} {{ now()->format('Y') }} {{ __('words.copy_write_msg_2') }}
                        </p>
                    </div>
            </div>
        </nav>

        <div id="content" class="p-md-5 pt-5">

            <div class="container-fluid">
                @if (session()->has('success'))
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())

                    @foreach ($errors->all() as $error)
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                            {{ $error }}
                        </div>
                    @endforeach
                @endif
                {{ $slot }}
            </div>
            <form action="" method="post" id="delete-form" style="dislplay:none">
                @csrf
                @method('delete')
            </form>


        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('assets/dashboard/js/popper.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/dashboard/js/main.js') }}"></script>
    <script defer="defer" src="{{ asset('assets/dashboard/js/beacon.js') }}"
        data-cf-beacon="{&quot;rayId&quot;:&quot;68eb5ba4796d4d9f&quot;,&quot;token&quot;:&quot;cd0b4b3a733644fc843ef0b185f98241&quot;,&quot;version&quot;:&quot;2021.8.1&quot;,&quot;si&quot;:10}">
    </script>
    <script>
        function deleteImage(table, filename, id, field) {
            console.log(table);
            $.ajax({
                type: 'post',
                url: "{{ route('shop.remove.media') }}",
                data: {
                    'table': table,
                    'filename': filename,
                    'id': id,
                    'field': field,
                    '_token': '{{ csrf_token() }}'
                },
                success: function(response) {
                    location.reload();
                }
            })
        }
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
        function printDiv(divName) {

            var printContents = divName.parentNode.parentNode.children[0].innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#locations').select2();
        });
    </script>
    <script>
        function cskDelete(url) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    let deleteForm = document.getElementById('delete-form');
                    deleteForm.action = url;
                    deleteForm.submit();
                }
            })
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous"></script>
    @if (session()->has('success'))
        <script>
            toastr.success("{{ session('success') }}")
        </script>
    @endif
    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)

                toastr.error('{{ $error }}')
            @endforeach
        </script>
    @endif


    @stack('scripts')


</body>

</html>
