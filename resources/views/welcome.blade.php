
<x-main>
    {{-- Section content start --}}
    <section class=" o-hidden mt-md-5 pt-5 pb-0 ">
        <div class="container border-bottom-1 pb-5" style="margin-top: 40px">
            <div class="row justify-content-between">
                <div class="col-lg-8 d-flex flex-column text-center text-lg-left mb-5 mb-lg-0">
                    <div class="pr-xl-5">
                        {{-- <h1 class="display-3">{!! __('words.home_hero_sec_title') !!} </h1>
                  <p class="lead">{!! __('words.home_hero_sec_pera') !!}
                  <b>{{ __('words.visa') }}, {{ __('words.mastercard') }} {{ __('words.and') }} {{ __('words.vipps') }}</b> {{ __('words.home_hero_sec_pera_2') }} <br> <br><b><h2>{{ __('words.home_hero_sec_pera_3') }}</h2></b>
                  </p> --}}
                        <h2 class=" section-title-1 mt-5">{!! __('words.new_home_hero_sec_title') !!}</h2>
                        {{-- <h4 class="text-white" style="line-height: 40px;">{!! __('words.home_hero_sec_subtitle') !!}</h4> --}}
                        <p class="text-white sec-pera mt-5">{!! __('words.new_home_hero_pera1') !!}</p> <br>
                        <p class="text-white sec-pera">{!! __('words.New_home_hero_pera2') !!}</p>
                        {{-- <h5 class="text-white">{{ __('words.home_hero_sec_pera_3') }}</h5> --}}
                        <div class="d-flex align-items-center">
                            <div class="col-md-6">
                                <div class=" btn-home">
                                    <a href="{{route('shop.register')}}" class="">
                                        <h4 class="mb-0 text-white">{!! __('words.new_main_btn_sec') !!} </h4>
                                        <p class="mb-0 text-white">{!! __('words.new_main_btn_title') !!}</p>
                                        <small class="text-white d-block" style="font-size: 10px;margin-top:-5px">{!! __('words.new_main_btn_subtitle') !!}</small>
                                    </a>
                                </div>
                            </div>
                            <p class="text-white">{!! __('words.new_home_qr_text') !!}</p>
                            <div class="ml-3">
                                <x-qr.direct :size="90" url="{{route('shop.register')}}" :disabled="true"/>
                                {{-- <img src="{{ asset('images/qr.jpg') }}" alt="" height="90"> --}}
                            </div>
                        </div>
                        {{-- <div
                            class="d-flex flex-column flex-sm-row mt-2 mt-md-5 justify-content-center justify-content-lg-start">

                            <a href="https://iziibuy.com/register-as-shop"
                                class="btn btn-primary btn-loading"><span>{{ __('words.home_hero_sec_btn') }}</span>
                            </a>

                        </div> --}}
                    </div>
                </div>
                <div class="col-xl-4">


                    <img class="img-fluid w-100" src="{{ asset('images/landing/man-and-woman-.JPG') }}"
                        alt="Screenshot" width="" style="border-radius: 15px">


                </div>
            </div>
        </div>
        {{-- <div class="w-50 h-50 bottom right position-absolute">
            <div class="blob h-100 w-100 bottom right bg-warning opacity-90"></div>
        </div> --}}
        {{-- <div class="divider divider-bottom bg-primary-3 mt-5"></div> --}}
    </section>
    {{-- <section class=" text-white">
        <div class="container border-bottom-1 pb-5">
            <div class="row justify-content-center ">
                <div class="col-md-6 mb-5 mb-lg-0 " style="">
                    <img src="{{ asset('frontend-asset/img/mobile-app/mach-e_iphone3.png') }}" alt="shoppingcart"
                        class="" width="220">
                </div>
                <div class="col-md-4 mb-5 mb-lg-0 mt-4">
                    <h1 class="display-5 section-title-1">{!! __('words.home_feature_sec_title') !!}</h1>
                    <ul class="function-lists">
                        <li><i class="fa fa-check" aria-hidden="true"></i> {!! __('words.home_feature_item1') !!}</li>
                        <li><i class="fa fa-check" aria-hidden="true"></i> {!! __('words.home_feature_item2') !!}</li>
                        <li><i class="fa fa-check" aria-hidden="true"></i> {!! __('words.home_feature_item3') !!}</li>
                        <li><i class="fa fa-check" aria-hidden="true"></i> {!! __('words.home_feature_item4') !!}</li>

                    </ul>
                    <h5 class="section-title-1"><a href=""
                            class="section-title-1 ml-4">{!! __('words.home_feature_button') !!}</a></h5>
                </div>

            </div>
        </div>
    </section> --}}
    <section class=" text-white pb-0">
        <div class="container border-bottom-1 pb-5">
            <div class="row justify-content-between">

                <div class="col-md-6 mb-5 mb-lg-0 mt-4">
                    <h2 class=" section-title-1 text-center mb-4">{!! __('words.new_home_function_sec') !!}</h2>
                    <ul class="function-lists">
                        <li>
                            <p><span class="list-heading">{!! __('words.new_home_function_heading1') !!} :</span> {!! __('words.new_home_function_title1') !!}</p>
                        </li>
                        <li>
                            <p><span class="list-heading">{!! __('words.new_home_function_heading2') !!}:</span> {!! __('words.new_home_function_title2') !!}</p>
                        </li>
                        <li>
                            <p><span class="list-heading">{!! __('words.new_home_function_heading3') !!} :</span>{!! __('words.new_home_function_title3') !!}
                            </p>
                        </li>
                        <li>
                            <p><span class="list-heading">{!! __('words.new_home_function_heading4') !!} :</span> {!! __('words.new_home_function_title4') !!}

                            </p>
                        </li>
                        <li>
                            <p><span class="list-heading">{!! __('words.new_home_function_heading5') !!} :</span> {!! __('words.new_home_function_title5') !!}


                            </p>
                        </li>

                    </ul>

                </div>
                <div class="col-md-4 mb-5 mb-lg-0 mt-md-5 pt-md-5" style="">
                    <div class="row m-0 justify-content-center">
                        <div class="col-md-5 function-item mb-2 d-flex align-items-center justify-content-center"
                            style="background-image: linear-gradient(rgba(4, 9, 30, 0.488), rgba(4, 9, 30, 0.384)),url({{ asset('images/landing/digital.jpg') }})">
                            <h5 class="function-item-title">{!! __('words.digital_bank') !!}</h5>
                        </div>
                        <div class="col-md-5 function-item mb-2 d-flex align-items-center justify-content-center ml-md-2"
                            style="background-image: linear-gradient(rgba(4, 9, 30, 0.488), rgba(4, 9, 30, 0.384)),url({{ asset('images/landing/booking.webp') }})">
                            <h5 class="function-item-title">{!! __('words.new_home_booking') !!}</h5>
                        </div>
                        <div class="col-md-5 function-item mb-2 d-flex align-items-center justify-content-center "
                            style="background-image: linear-gradient(rgba(4, 9, 30, 0.488), rgba(4, 9, 30, 0.384)),url({{ asset('images/landing/B2B.webp') }})">
                            <h5 class="function-item-title">{!! __('words.b2b') !!}</h5>
                        </div>
                        <div class="col-md-5 function-item mb-2 d-flex align-items-center justify-content-center ml-md-2"
                            style="background-image: linear-gradient(rgba(4, 9, 30, 0.488), rgba(4, 9, 30, 0.384)),url({{ asset('images/landing/Selvbetjening.webp') }})">
                            <h5 class="function-item-title">{!! __('words.personal_text') !!}</h5>
                        </div>
                        <div class="col-md-5 function-item mb-2 d-flex align-items-center justify-content-center "
                            style="background-image: linear-gradient(rgba(4, 9, 30, 0.488), rgba(4, 9, 30, 0.384)),url({{ asset('images/landing/B2C.webp') }})">
                            <h5 class="function-item-title">{!! __('words.b2c') !!}</h5>
                        </div>
                        <div class="col-md-5 function-item mb-2 d-flex align-items-center justify-content-center ml-md-2"
                            style="background-image: linear-gradient(rgba(4, 9, 30, 0.488), rgba(4, 9, 30, 0.384)),url({{ asset('images/landing/Abennoment.webp') }})">
                            <h5 class="function-item-title">{!! __('words.subscription') !!}</h5>
                        </div>
                        <div class="col-10 btn-home mt-5" style="width: 88%">
                            <a href="{{route('shop.register')}}" class="">
                                <h4 class="mb-0 text-white">{!! __('words.new_main_btn_sec') !!} </h4>
                                <p class="mb-0 text-white">{!! __('words.new_main_btn_title') !!}</p>
                                <small class="text-white d-block" style="font-size: 10px;margin-top:-5px">{!! __('words.new_main_btn_subtitle') !!}</small>
                            </a>
                        </div>
                   
                    </div>

                </div>

            </div>
        </div>
    </section>
    {{-- <section class="o-hidden">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 mb-5 mb-xl-0">
                    <div class="text-center text-xl-left mb-lg-5">
                        <h3 class="h1">
                            {!! __('words.smart_sec_title') !!}
                            <mark>{{ __('words.smart_sec_title_2') }}</mark> {{ __('words.smart_sec_title_3') }}
                        </h3>
                    </div>
                    <ul class="nav nav-pills justify-content-center flex-xl-column pr-xl-5" role="tablist">
                        <li class="nav-item">
                            <a class="btn btn-lg btn-primary active w-100" id="tab-1" data-toggle="tab"
                                href="#home-6" role="tab" aria-controls="tab-1" aria-selected="true">
                                <div class="d-flex align-items-center">
                                    <img src="{{ secure_asset('frontend-asset/img/icons/theme/design/layers.svg') }}"
                                        alt="Icon" class="icon bg-primary" data-inject-svg>
                                    <span>{{ __('words.smart_sec_btn') }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-lg btn-primary w-100" id="tab-2" data-toggle="tab"
                                href="#profile-6" role="tab" aria-controls="tab-2" aria-selected="false">
                                <div class="d-flex align-items-center">
                                    <img src="{{ secure_asset('frontend-asset/img/icons/theme/devices/display-1.svg') }}"
                                        alt="Icon" class="icon bg-primary" data-inject-svg>
                                    <span>{{ __('words.smart_sec_list1') }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-lg btn-primary w-100" id="tab-3" data-toggle="tab"
                                href="#contact-6" role="tab" aria-controls="tab-3" aria-selected="false">
                                <div class="d-flex align-items-center">
                                    <img src="{{ secure_asset('frontend-asset/img/icons/theme/general/folder.svg') }}"
                                        alt="Icon" class="icon bg-primary" data-inject-svg>
                                    <span>{{ __('words.samrt_sec_list2') }}</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="home-6" role="tabpanel"
                            aria-labelledby="tab-1">
                            <div class="row justify-content-around align-items-center">
                                <div class="col-8 col-sm-4 col-lg-4 col-xl-5">
                                    <img src="{{ secure_asset('frontend-asset/img/mobile-app/mobile-app-2.png') }}"
                                        alt="Screenshot" class="img-fluid">
                                </div>
                                <div class="col-sm col-md-6 mt-4 mt-sm-0">
                                    <h5>{{ __('words.hybrid') }}</h5>
                                    <p>
                                        {{ __('words.samrt_sec_pera') }}
                                    </p>
                                    <div class="mt-4">
                                        <div
                                            class="media rounded align-items-center pl-3 pr-3 pr-md-4 py-2 d-inline-flex text-left bg-secondary">
                                            <img src="{{ secure_asset('frontend-asset/img/avatars/female-4.jpg') }}"
                                                alt="Ashley Mance avatar image"
                                                class="avatar avatar-sm flex-shrink-0 mr-3">
                                            <div class="text-dark mb-0">{!! __('words.smart_sec_msg') !!}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile-6" role="tabpanel" aria-labelledby="tab-2">
                            <div class="row justify-content-around align-items-center">
                                <div class="col-8 col-sm-4 col-lg-4 col-xl-5">
                                    <img src="{{ secure_asset('frontend-asset/img/mobile-app/mobile-app-3.png') }}"
                                        alt="Screenshot" class="img-fluid">
                                </div>
                                <div class="col-sm col-md-6 mt-4 mt-sm-0">
                                    <h5>{{ __('words.front_commissions') }}</h5>
                                    <p>
                                        {{ __('words.front_commissions_sub') }}
                                    </p>
                                    <div class="mt-4">
                                        <div
                                            class="media rounded align-items-center pl-3 pr-3 pr-md-4 py-2 d-inline-flex text-left bg-secondary">
                                            <img src="{{ secure_asset('frontend-asset/img/avatars/male-1.jpg') }}"
                                                alt="Harvey Derwent avatar image"
                                                class="avatar avatar-sm flex-shrink-0 mr-3">
                                            <div class="text-dark mb-0">&ldquo;{!! __('words.smart_sec_msg2') !!}&rdquo;</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile-6" role="tabpanel" aria-labelledby="tab-2">
                            <div class="row justify-content-around align-items-center">
                                <div class="col-8 col-sm-4 col-lg-4 col-xl-5">
                                    <img src="{{ secure_asset('frontend-asset/img/mobile-app/mobile-app-3.png') }}"
                                        alt="Screenshot" class="img-fluid">
                                </div>
                                <div class="col-sm col-md-6 mt-4 mt-sm-0">
                                    <h5>{{ __('words.front_control') }}</h5>
                                    <p>
                                        {{ __('words.front_control_sub') }} </p>
                                    <div class="mt-4">
                                        <div
                                            class="media rounded align-items-center pl-3 pr-3 pr-md-4 py-2 d-inline-flex text-left bg-secondary">
                                            <img src="{{ secure_asset('frontend-asset/img/avatars/male-1.jpg') }}"
                                                alt="Harvey Derwent avatar image"
                                                class="avatar avatar-sm flex-shrink-0 mr-3">
                                            <div class="text-dark mb-0">&ldquo;{!! __('words.smart_sec_msg2') !!}&rdquo;</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="contact-6" role="tabpanel" aria-labelledby="tab-3">
                            <div class="row justify-content-around align-items-center">
                                <div class="col-8 col-sm-4 col-lg-4 col-xl-5">
                                    <img src="{{ secure_asset('frontend-asset/img/mobile-app/mobile-app-4.png') }}"
                                        alt="Screenshot" class="img-fluid">
                                </div>
                                <div class="col-sm col-md-6 mt-4 mt-sm-0">
                                    <h5>{{ __('words.front_stock') }}</h5>
                                    <p>
                                        {{ __('words.front_control_sub') }}
                                    </p>
                                    <div class="mt-4">
                                        <div
                                            class="media rounded align-items-center pl-3 pr-3 pr-md-4 py-2 d-inline-flex text-left bg-secondary">
                                            <img src="{{ secure_asset('frontend-asset/img/avatars/female-3.jpg') }}"
                                                alt="Mary Goddard avatar image"
                                                class="avatar avatar-sm flex-shrink-0 mr-3">
                                            <div class="text-dark mb-0">
                                                &ldquo;{{ __('words.front_control_sub2') }}&rdquo;</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="p-0 bg-primary row no-gutters o-hidden">
        <div class="col-lg-5 col-xl-6 d-flex align-items-center justify-content-center">

            <img src="{{ secure_asset('frontend-asset/img/heros/happy_card.jpg') }}" alt="Image"
                class="w-100 h-100">
            <div class="divider divider-side bg-primary d-none d-lg-block"></div>
        </div>
        <div class="col-lg-7 col-xl-6">
            <section>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col col-md-10 col-xl-9">
                            <div class="text-white text-center text-lg-left">
                                <h3 class="h1">{{ __('words.solution_sec_title') }}</h3>
                                <p class="lead">
                                    {!! __('words.solution_sec_pera') !!} <b>{{ __('words.visa') }}, {{ __('words.mastercard') }}
                                        {{ __('words.and') }} {{ __('words.vipps') }}</b>
                                    {{ __('words.solution_sec_pera_2') }}
                                </p>
                            </div>
                            <div class="d-flex flex-wrap justify-content-center justify-content-lg-start mt-4 mt-md-5">
                                <div class="mx-2 ml-sm-0 ml-sm-0 mb-2 bg-white rounded p-2 pr-3 p-md-3 pr-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-success-alt">
                                            <img src="{{ secure_asset('frontend-asset/img/icons/interface/icon-check.svg') }}"
                                                alt="Binoculars icon" class="m-2 icon icon-xs bg-success"
                                                data-inject-svg>
                                        </div>
                                        <h6 class="mb-0 ml-3">{{ __('words.solution_sec_list1') }}</h6>
                                    </div>
                                </div>
                                <div class="mx-2 ml-sm-0 ml-sm-0 mb-2 bg-white rounded p-2 pr-3 p-md-3 pr-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-success-alt">
                                            <img src="{{ secure_asset('frontend-asset/img/icons/interface/icon-check.svg') }}"
                                                alt="Layouts icon" class="m-2 icon icon-xs bg-success"
                                                data-inject-svg>
                                        </div>
                                        <h6 class="mb-0 ml-3">{{ __('words.solution_sec_list2') }}</h6>
                                    </div>
                                </div>
                                <div class="mx-2 ml-sm-0 ml-sm-0 mb-2 bg-white rounded p-2 pr-3 p-md-3 pr-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-success-alt">
                                            <img src="{{ secure_asset('frontend-asset/img/icons/interface/icon-check.svg') }}"
                                                alt="Box icon" class="m-2 icon icon-xs bg-success" data-inject-svg>
                                        </div>
                                        <h6 class="mb-0 ml-3">{{ __('words.solution_sec_list3') }}</h6>
                                    </div>
                                </div>
                                <div class="mx-2 ml-sm-0 ml-sm-0 mb-2 bg-white rounded p-2 pr-3 p-md-3 pr-md-4">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-success-alt">
                                            <img src="{{ secure_asset('frontend-asset/img/icons/interface/icon-check.svg') }}"
                                                alt="Lightning icon" class="m-2 icon icon-xs bg-success"
                                                data-inject-svg>
                                        </div>
                                        <h6 class="mb-0 ml-3">{{ __('words.solution_sec_list4') }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
    <section class="o-hidden">
        <div class="container">
            <div class="row align-items-center justify-content-around flex-lg-row-reverse">
                <div class="col-md-9 col-lg-6 col-xl-5 mb-4 mb-lg-0 pl-lg-5 pl-xl-0">
                    <div>
                        <h2 class="h1 text-center text-lg-left">{{ __('words.conversion_sec_title') }}</h2>
                        <div class="d-flex flex-wrap justify-content-center justify-content-lg-start">
                            <div class="my-4">
                                <div class="d-flex">
                                    <div class="mr-3 mr-md-4">
                                        <img src="{{ secure_asset('frontend-asset/img/icons/theme/general/bookmark.svg') }}"
                                            alt="Bookmark icon" class="icon bg-primary" data-inject-svg>
                                    </div>
                                    <div>
                                        <h5>{{ __('words.conversion_col_1_title') }}</h5>
                                        <div>
                                            {{ __('words.conversion_col_1_pera') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="my-4">
                                <div class="d-flex">
                                    <div class="mr-3 mr-md-4">
                                        <img src="{{ secure_asset('frontend-asset/img/icons/theme/design/select.svg') }}"
                                            alt="Selection interface icon" class="icon bg-primary" data-inject-svg>
                                    </div>
                                    <div>
                                        <h5>{{ __('words.conversion_col_2_title') }}</h5>
                                        <div>
                                            {{ __('words.conversion_col_2_pera') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg col-xl-6">
                    <div class="row justify-content-center" data-jarallax-element="-50">
                        <div class="col-10 col-sm-8 col-md-6 col-lg-8 col-xl-6">
                            <img class="img-fluid position-relative"
                                src="{{ secure_asset('frontend-asset/img/mobile-app/mobile-app-3.png') }}"
                                alt="Screenshot">
                            <div class="h-75 w-75 position-absolute bottom right d-none d-lg-block"
                                data-jarallax-element="-50">
                                <div class="blob blob-4 w-100 h-100 bg-success opacity-90"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="o-hidden">
        <div class="container">
            <div class="row align-items-center justify-content-around text-center text-lg-left">
                <div class="col-md-9 col-lg-6 col-xl-5 mb-4 mb-lg-0 pr-lg-5 pr-xl-0 order-lg-2">
                    <div>
                        <h2 class="display-4">{{ __('words.order_today_sec_title') }}</h2>
                        <p class="lead">{!! __('words.order_today_sec_pera') !!}
                            <b>{{ __('words.visa') }}, {{ __('words.mastercard') }} {{ __('words.and') }}
                                {{ __('words.vipps') }}</b>, {{ __('words.order_today_sec_pera_2') }}.
                        </p>
                        <div
                            class="d-flex flex-column flex-sm-row mt-4 mt-md-5 justify-content-center justify-content-lg-start">
                            <a href="https://iziibuy.com/register-as-shop"
                                class="btn btn-primary btn-loading"><span>{{ __('words.order_today_sec_btn') }}</span>
                            </a>

                        </div>
                    </div>
                </div>
                <div class="col-lg order-lg-1">
                    <div class="row justify-content-center" data-jarallax-element="-50">
                        <div class="col-10 col-sm-8 col-md-6 col-lg-8 col-xl-6">
                            <img class="img-fluid position-relative"
                                src="{{ secure_asset('frontend-asset/img/mobile-app/mobile-app-4.png') }}"
                                alt="Screenshot">
                            <div class="h-50 w-50 position-absolute bottom left d-none d-lg-block"
                                data-jarallax-element="-50">
                                <div class="blob blob-2 w-100 h-100 bg-primary-2 opacity-90 top right"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    {{-- Section content end --}}
    <section class=" text-white  pt-0 mt-0 pb-0">
        <div class="container border-bottom-1">
            <div class="row justify-content-between">

                <div class="col-md-5 d-flex align-items-center card-sec" style="">
                    <div>
                        <h2 class=" section-title-1 text-center">{!! __('words.about_section') !!}
                        </h2>
                        <p class="text-white sec-pera mt-5">{!! __('words.about_section_title') !!}
                        </p>
                        <p class="text-white sec-pera ">{!! __('words.about_section_subtitle') !!}</p>
                    </div>

                </div>
                <div class="col-md-4 img-thumb-sec">
                    <img src="{{ asset('images/landing/female.JPG') }}" class=" card-thumb-pc" alt=""
                        width="100%" height="650">
                    <img src="{{ asset('images/landing/female-mobile.jpg') }}" class=" card-thumb-mobile"
                        alt="" width="100%" height="450">
                </div>
                <div class="col-md-3">
                    <div class="bank-cards" style="">
                        <div class="bank-card">
                            <h5>{!! __('words.about_1') !!}
                            </h5>
                        </div>
                        <div class="bank-card">
                            <h5>{!! __('words.about_2') !!}

                            </h5>
                        </div>
                        <div class="bank-card">
                            <h5>{!! __('words.about_3') !!}
                            </h5>
                        </div>
                        <div class="bank-card">
                            <h5>{!! __('words.about_4') !!}
                            </h5>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </section>
</x-main>

