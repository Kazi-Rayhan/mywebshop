@foreach ($products as $product)
    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
        <div class="product-card card-gape border h-100 d-flex flex-column">
            @if ($product->image)
                <div class="product-img my-auto">
                    <a href="{{ $product->path() }}">
                        <img src="{{ Iziibuy::image($product->image) }}" class="img-fluid" alt="produkt">
                    </a>
                </div>
            @endif
            <div class="product-content mt-auto">
                <div class="product-name">
                    <h6><a href="{{ $product->path() }}">{{ Str::limit($product->name, $limit = 20, $end = '...') }}</a>
                    </h6>
                </div>

                <div class="product-price">
                    @if (!$product->is_variable)
                        @if ($product->previousprice)
                            <h6><del
                                    class="mr-2">{{ Iziibuy::price($product->previousPrice) }}</del>{{ Iziibuy::price($product->currentPrice) }}
                            </h6>
                        @else
                            <h6>{{ Iziibuy::price($product->currentPrice) }} </h6>
                        @endif
                    @endif
                    {{-- @if (Shop::average_rating($product->ratings) > 0) --}}
                    {{-- <div class="product-rating">
							<i class="fas fa-star"></i>
							<span>{{Shop::average_rating($product->ratings)}}/5</span>
						</div> --}}
                    {{-- @endif --}}
                </div>
                <div class="product-btn">
                    <form action="{{route('cart.store',request('user_name')??$product->shop->user_name)}}" method="post">
                    @csrf
                    <input type="hidden" class="form-control qty" value="1" min="1" name="quantity">
                    <input type="hidden" name="product_id"value="{{ $product->id }}" />

                    @if (!$product->is_variable)
                        <button class="btn btn-outline buy_btn"><i
                                class="fas fa-shopping-basket"></i>{!! strip_tags(__('words.add_cart_btn')) !!}</button>
                    @else
                        <a href="{{ $product->path() }}" class="btn btn-outline buy_btn">
                            <i class="fas fa-shopping-basket"></i>
                            <span>{{ __('words.select_option') }}</span>
                        </a>
                    @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
