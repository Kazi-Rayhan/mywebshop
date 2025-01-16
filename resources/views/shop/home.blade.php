<x-shop-front-end>
    @push('style')
        <link rel="stylesheet" href="{{ asset('css/custom/product-details-3.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom/star-rating.css') }}" media="all" type="text/css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <style type="text/css">
            @media screen and (max-width: 991px) {
                #toggle_filter {
                    display: none;
                }
            }

            @media screen and (min-width:991px) {
                .hide-lg {
                    display: none;
                }
            }

            @media screen and (min-width:767px) {
                .hide-tab {
                    display: none;
                }
            }

            @media screen and (max-width: 400px) {
                li.page-item {
                    display: none;
                }

                .page-item:first-child,
                .page-item:nth-child(2),
                .page-item:nth-last-child(2),
                .page-item:last-child,
                .page-item.active,
                .page-item.disabled {
                    display: block;
                }
            }

            #sidebar {
                color: #fff;
                -webkit-transition: all .3s;
                -o-transition: all .3s;
                transition: all .3s;
                position: relative;
                z-index: 0;
                border-left: 1px solid rgba(0, 0, 0, .05)
            }

            #sidebar .h6 {
                color: #fff
            }

            #sidebar.active {
                margin-left: -270px
            }

            #sidebar ul.components {
                padding: 0
            }



            #sidebar ul li a span {
                margin-right: 30px;
            }

            #sidebar ul li>ul {
                margin-left: 10px
            }


            #sidebar ul li a {
                display: flex;
                justify-content: space-between;
                padding: 10px 0;
                display: block;
                color: #000;
                border-bottom: 1px solid rgba(0, 0, 0, .05);
                font-size: 17px;
                transition: 1s
            }

            #sidebar ul li a:hover {
                color: #807878;
            }

            #sidebar .dropdown-toggle::after {
                float: right
            }

            .active {
                color: var(--brandcolor);
                text-decoration: underline;
                text-decoration-color: var(--brandcolor);
            }




            @media(max-width:767.98px) {
                #sidebar {
                    min-width: 100%;
                    max-width: 180px;
                    border-left: none
                }
            }

            #sidebar .custom-menu {
                display: inline-block;
                position: absolute;
                top: 20px;
                right: 0;
                margin-right: -20px;
                -webkit-transition: .3s;
                -o-transition: .3s;
                transition: .3s
            }

            @media(prefers-reduced-motion:reduce) {
                #sidebar .custom-menu {
                    -webkit-transition: none;
                    -o-transition: none;
                    transition: none
                }
            }

            #sidebar .custom-menu .btn {
                width: 60px;
                height: 60px;
                border-radius: 50%;
                position: relative
            }

            #sidebar .custom-menu .btn i {
                margin-right: -40px;
                font-size: 14px
            }

            #sidebar .custom-menu .btn.btn-primary {
                background: 0 0;
                border-color: transparent
            }

            #sidebar .custom-menu .btn.btn-primary:after {
                z-index: -1;
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                content: '';
                -webkit-transform: rotate(45deg);
                -ms-transform: rotate(45deg);
                transform: rotate(45deg);
                background: #fc7fb2;
                border-radius: 10px
            }

            #sidebar .custom-menu .btn.btn-primary:hover,
            #sidebar .custom-menu .btn.btn-primary:focus {
                background: 0 0 !important;
                border-color: transparent !important
            }
        </style>
    @endpush

    @if ($sliders->count() > 0)
        <section class="slider">
            <div id="homeslider" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($sliders as $slider)
                        <div class="carousel-item {{ $loop->index == 0 ? 'active' : '' }}">
                            <img class="d-block w-100" src="{{ Iziibuy::image($slider->image) }}"
                                alt="{{ setting('site.title') }}">
                            @if ($slider->heading)
                                <div class="carousel-caption d-none d-md-block bg-dark rounded p-2" style="opacity:.8">
                                    @if ($slider->heading)
                                        <h5 class="text-light">{{ $slider->heading }}</h5>
                                        <p>{{ $slider->paragraph }}</p>
                                    @endif
                                    @if ($slider->url)
                                        <a href="{{ $slider->url }}" class="btn btn-outline-light mt-3">
                                            {{ $slider->button }}</a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <a class="carousel-control-prev" href="#homeslider" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Forrige</span>
                </a>
                <a class="carousel-control-next" href="#homeslider" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Neste</span>
                </a>
            </div>
        </section>
    @endif
    <section class="section trend-part">
        <div class=" @if ($shop->show_categories_on_home) container-fluid @else container @endif">

            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading">
                        <h2 class="title">{!! __('words.featured_products') !!}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @if ($shop->show_categories_on_home)
                    <div class="col-md-3">
                        <nav id="sidebar">
                            <div class="p-4 pt-5">
                                <h5>{!! strip_tags(__('words.products_category_sec_title')) !!}</h5>

                                {!! $category_list !!}

                            </div>
                        </nav>
                    </div>
                @endif
                <div class="@if ($shop->show_categories_on_home) col-md-9 @else col-12 @endif">
                    <div class="row">
                        <x-products :products="$new_products" />

                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('js')
        <script>
            $(document).ready(function() {
                // Get all elements with aria-expanded="true"
                const expandedElements = $('[aria-expanded="true"]');

                // Loop through each expanded element
                expandedElements.each(function() {
                    // Get all parent elements of the expanded element
                    const parentElements = $(this).parentsUntil('body');

                    // Loop through each parent element and set the aria-expanded attribute if it has a data-toggle attribute of "collapse"
                    parentElements.each(function() {
                        if ($(this).attr('data-toggle') === 'collapse') {
                            $(this).attr('aria-expanded', 'true');
                        }

                        // Add the "show" class to all parent ul elements that have a class of "collapse"
                        if ($(this).is('ul') && $(this).hasClass('collapse')) {
                            $(this).addClass('show');
                        }
                    });
                });
            });
        </script>
        <script>
            $("#filter_button").click(function() {
                if ($('#toggle_filter').is(':visible')) {
                    $("#toggle_filter").css("display", "none");
                } else {
                    $("#toggle_filter").css("display", "block");
                }
            });
        </script>

        <script>
            [...$('.cateogry-link')].map(el => {

                $(el).click((event) => {

                    event.stopPropagation()
                    event.preventDefault();

                    window.location.href = event.target.dataset.url
                })
            })
        </script>
    @endpush
</x-shop-front-end>
