<x-shop-front-end>
    @section('title', $product->name)
    @push('style')
        <link rel="stylesheet" href="{{ asset('css/custom/product-details-3.css') }}">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    @endpush
    <section class="product-part pb-3">
        <div class="container">
            <div class="row">

                <div class="col-md-12 col-lg-12 text-center">
                    <img src="{{ Voyager::image($product->image) }}" alt="product" class="mb-3" height="300px">
                    <div class="product-name">
                        <h3>{{ $product->title }}</h3>
                        <h4 class="mt-4">{{ Iziibuy::price($product->price) }}</h4>
                    </div>
                    @if (auth()->check() &&
                            @$product->memberships()->where('user_id', auth()->id())->first()->status == 1)
                        <span class='text text-info border border-info h5 px-2'>løping</span>
                    @else
                        <a href="{{ $product->checkOut() }}" class="btn btn-outline btn-sm">
                            Subscribe
                        </a>
                    @endif
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
                                    <a class="nav-link" id="rating-tab" data-toggle="tab" href="#products"
                                        role="tab" aria-controls="rating" aria-selected="false">Products</a>
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
                                <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="rating-tab">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <x-products :products="$product->products" />
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
    </div>
</x-shop-front-end>