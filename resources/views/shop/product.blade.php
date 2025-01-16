<x-shop-front-end>
    @push('style')
        <link rel="stylesheet" href="{{ asset('css/custom/product-details-3.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom/star-rating.css') }}" media="all" type="text/css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <style type="text/css">
            .qty {
                width: 100px;
                padding: 0px 15px;
                height: 50px;
                border-radius: 3px;
                border: 2px solid #e8e8e8;
            }
        </style>
    @endpush
    <section class="product-part pb-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6">
                    <div class="preview-slider slider-arrow border-0">
                        @if ($product->image)
                            <img src="{{ Iziibuy::image($product->image) }}" alt="product" class=""
                                data-image={{ $product->image }}>
                        @endif
                        @foreach ($product->images as $image)
                            <img src="{{ Iziibuy::image($image) }}" alt="product">
                        @endforeach
                        @foreach ($product->variations as $sub_product)
                            @if ($sub_product->image)
                                <img src="{{ Iziibuy::image($sub_product->image) }}" alt="product"
                                    data-image={{ $sub_product->image }}
                                    data-variation="{{ json_encode($sub_product->variation) }}">
                            @endif
                        @endforeach
                    </div>

                    <div class="thumb-slider">
                        @if ($product->image)
                            <img src="{{ Iziibuy::image($product->image) }}" alt="product">
                        @endif

                        @foreach ($product->images as $image)
                            <img src="{{ Iziibuy::image($image) }}" alt="product">
                        @endforeach
                        @foreach ($product->variations as $sub_product)
                            @if ($sub_product->image)
                                <img src="{{ Iziibuy::image($sub_product->image) }}" alt="product"
                                    data-variation="{{ json_encode($sub_product->variation) }}">
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="product-name">
                        <h3 style="fon">{{ $product->name }}</h3>
                        @if ($product->ean)
                            <small class="text-secondary">EAN - {{ $product->ean }}</small>
                        @endif
                    </div>
                    <div class="product-review">
                        <ul>
                            <li><i class="fas fa-star"></i></li>
                            <li><i class="fas fa-star"></i></li>
                            <li><i class="fas fa-star"></i></li>
                            <li><i class="fas fa-star"></i></li>
                            <li><i class="fas fa-star"></i></li>
                            <li><a href="#">({{ $product->ratings->count() }} Vurderinger)</a></li>
                        </ul>
                    </div>
                    <div class="product-price">
                        @if ($product->is_variable)
                            <h6 id="amount"></h6>
                        @else
                            @if ($product->previousPrice)
                                <h6><del class="mr-2">{{ Iziibuy::price($product->previousPrice) }}</del><span
                                        id="sale">{{ Iziibuy::price($product->currentPrice) }}</span></h6>
                            @else
                                <h6>{{ Iziibuy::price($product->currentPrice) }}</h6>
                            @endif
                        @endif
                    </div>
                    @if ($product->quantity > 0)
                        <p class="mb-1">{{ __('words.product_in_stoke') }}: {{ $product->quantity }}</p>
                    @else
                        <p class="text-danger mb-1">Utsolgt</p>
                    @endif
                    <p class="mb-1">{{ __('words.product_prod_num') }} : {{ $product->sku }}</p>
                    <div class="row my-3">
                        <div class="col-12">
                            <h3 class="mb-3">
                                {{ __('words.product_available_at') }}
                            </h3>
                            <table>

                                <ul class="list-group">

                                    @foreach ($shop->stores as $store)
                                        @if ($store->products->find($product))
                                            <li class="list-group-item"> <i class="fas fa-store text-primary m-2"></i>
                                                {{ $store->address }} ,{{ $store->city }} <br>
                                                {{ $store->state }} </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </table>
                        </div>
                    </div>
                    <div class="product-summery">
                        <p>{!! $product->details !!}</p>
                    </div>
                    <div class="product-cart">
                        <div id="notice" class="text-danger font-weight-bold"></div>
                        <form action="{{ route('cart.store', request('user_name')) }}" method="post"
                            class="form-inline">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}" />
                            @if ($product->is_variable && count($product->variations) > 0)
                                <div class="row mt-2 pt-2 w-100 mb-2">
                                    @foreach ($product->attributes as $attribute)
                                        <div class="form-group col-md-4 pl-0 ">
                                            <label for="{{ $attribute->name }}">
                                                {{ str_replace('_', ' ', $attribute->name) }}</label>
                                            <select class="form-control w-100"
                                                id="{{ str_replace(' ', '_', $attribute->name) }}"
                                                name="variable_attribute[{{ $attribute->name }}]"
                                                data-variation="{{ $attribute->name }}" onchange="change_variable()"
                                                onload="" required>

                                                @foreach ($attribute->value as $value)
                                                    <option value="{{ $value }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endforeach

                                </div>
                            @endif


                            <div class="row">
                                <div class="input-group">
                                    <input type="number" class="form-control qty" value="1" min="1"
                                        name="quantity" style="width:80px">
                                </div>
                            </div>
                            <button id="cart_button" class="btn btn-outline ml-4 buy_btn" type="submit"> <i
                                    class="fas fa-shopping-basket"></i> {{ __('words.product_prod_btn') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="product-info">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-info-content">
                        <h2>{{ __('words.dashboard_details') }}</h2>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row">{{ __('words.product_prod_num') }}</th>
                                    <td>{{ __('words.dashboard_sku') }}: {{ $product->sku }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('words.dashboard_weight') }}</th>
                                    <td>{{ $product->weight }} kg</td>
                                </tr>
                                <tr>
                                    <th scope="row">{{ __('words.products_category_sec_title') }}</th>
                                    <td>
                                        @foreach ($product->categories as $category)
                                            <a href="#" class="text-dark">{{ $category->name }} ,</a>
                                        @endforeach
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="product bg-white pt-3 pb-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="description-tab" data-toggle="tab"
                                        href="#description" role="tab" aria-controls="description"
                                        aria-selected="true">Beskrivelse</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="rating-tab" data-toggle="tab" href="#rating"
                                        role="tab" aria-controls="rating" aria-selected="false">Vurderinger</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-12">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="description" role="tabpanel"
                                    aria-labelledby="description-tab">
                                    <div class="card">
                                        <div class="card-body">
                                            {!! $product->description !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="rating" role="tabpanel"
                                    aria-labelledby="rating-tab">
                                    <div class="card">
                                        <div class="card-body">
                                            <form action="{{ url('/rating') }}" method="post">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h4>{{ __('words.product_rating') }}</h4>
                                                    </div>
                                                    <div class="col-lg-12 mt-3">
                                                        <input name="rating" type="number" value="1"
                                                            class="rating product_rating" min="1"
                                                            max="5" step=".5" data-size="xs">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="name">{{ __('words.dashboard_category_index_name') }}</label>
                                                            <input value="{{ old('name') }}" type="text"
                                                                class="form-control @error('name') is-invalid @enderror"
                                                                id="name"
                                                                placeholder="{{ __('words.dashboard_category_index_name') }}"
                                                                name="name" required>
                                                            @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="email">{{ __('words.checkout_form_email') }}</label>
                                                            <input value="{{ old('email') }}" type="text"
                                                                class="form-control @error('email') is-invalid @enderror"
                                                                id="email" placeholder="admin@example.com"
                                                                name="email" required>
                                                            @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label
                                                                for="comment">{{ __('words.charge_comment') }}</label>
                                                            <textarea name="comment" cols="30" rows="10" class="form-control @error('comment') is-invalid @enderror"
                                                                id="comment" required></textarea>
                                                            @error('comment')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <button type="submit"
                                                            class="btn btn-primary">{{ __('words.submit_btn') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <hr />
                                            @foreach ($product->ratings as $rating)
                                                <div class="row mt-5">
                                                    <div class="col-md-2">
                                                        <img src="{{ asset('storage/users/default.png') }}"
                                                            style="width:100px" class="img img-rounded" />
                                                        <p class="text-secondary">
                                                            {{ $rating->created_at->diffForHumans() }}</p>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <a class="float-left"
                                                            href="#"><strong>{{ $rating->name }}</strong></a>
                                                        <br />
                                                        <input name="rating" type="number"
                                                            value="{{ $rating->rating }}"
                                                            class="rating published_rating" data-size="xs">
                                                        <div class="clearfix"></div>
                                                        <p>{{ $rating->review }}</p>
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
            </div>

        </div>
    </div>
    @push('js')
        <script src="{{ asset('js/custom/star-rating.js') }}" type="text/javascript"></script>
        <script type="text/javascript">
            $('.thumb-slider').slick('slickGoTo', 1);
            @if ($product->is_variable)
                var products = {!! $product->subproductsuser->toJson() !!};
                change_variable();

                function change_variable() {
                    variations = {
                        @foreach ($product->attributes as $attribute)
                            '{{ $attribute->name }}': $('#{{ str_replace(' ', '_', $attribute->name) }}').val(),
                        @endforeach
                    }
                    var product = products.filter(function(product) {
                        return Object.keys(variations).every(function(variation) {
                            return product.variation[variation] === variations[variation];
                        });
                    });
                    //$('.preview-slider').slick('slickGoTo', 1);
                    // console.log(product[0].image);
                    if (product.length > 0) {
                        if (product[0].quantity == 0) {
                            $('#cart_button').prop("disabled", true);
                            $('#notice').text('This variation is not available please try different variation');
                        } else {
                            $('#cart_button').prop("disabled", false);
                            $('#notice').text('');
                        }
                        if (product[0].image) {
                            var element = $(`.preview-slider img[data-image='${product[0].image}']`);
                            //console.log(element.attr('data-slick-index'));
                            $('.preview-slider').slick('slickGoTo', element.attr('data-slick-index'))
                        }

                        if (product[0].saleprice) {
                            $text = "<del class='mr-2'>NOK" + product[0].price + "</del><span id='sale'>NOK" + product[0]
                                .saleprice + "</span>";
                        } else {
                            $text = "NOK " + product[0].price;
                        }
                        $("#amount").html($text);
                        if (product[0].image) {
                            $("#showcase").attr("src", "/storage/" + product[0].image);
                        }
                    } else {
                        $("#amount").text("No variation found. Please select other variation");
                    }
                };
            @endif
            $("#product_rating").rating({
                showCaption: true
            });
            $(".published_rating").rating({
                showCaption: false,
                readonly: true,
            });
        </script>
    @endpush
</x-shop-front-end>
