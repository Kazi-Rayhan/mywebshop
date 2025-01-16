<x-shop-front-end>
    @section('title', 'products')

    
        <div class="product bg-white pt-3 pb-3">
            <div class="container">
                <div class="row mt-5 poppins">

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <h3 class="border-bottom pb-2">{{ __('words.subscription_box_page_sec_title') }}</h3>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    @foreach ($boxes as $product)
                                        <div class="col-6 col-sm-6 col-md-3 col-lg-3 mb-4 ">
                                            <div class="product-card card-gape border h-100 d-flex flex-column">
                                                @if ($product->image)
                                                    <div class="product-img my-auto">
                                                        <a href="{{ $product->path() }}">
                                                            <img src="{{ Voyager::image($product->image) }}"
                                                                class="img-fluid" alt="produkt">
                                                        </a>
                                                    </div>
                                                @endif
                                                <div class="product-content mt-auto">
                                                    <div class="product-name">
                                                        <h6><a
                                                                href="{{ $product->path() }}">{{ Str::limit($product->title, $limit = 20, $end = '...') }}</a>
                                                        </h6>
                                                    </div>
                                                    <div class="product-price">
                                                        <h6>{{ Iziibuy::price($product->price) }} </h6>
                                                    </div>

                                                    @if (auth()->check() &&
                                                            $product->memberships()->where('user_id', auth()->id())->first() &&
                                                            $product->memberships()->where('user_id', auth()->id())->first()->status == 1)
                                                        <span
                                                            class='text text-info border border-info h5 px-2'>løping</span>
                                                    @else
                                                        <a href="{{ $product->checkOut() }}" class="btn btn-outline btn-sm">
                                                            {{ __('words.buy_btn') }}
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>


                        </div>
                    </div>


                </div>
            </div>
        </div>



    </x-shop-front-end>
