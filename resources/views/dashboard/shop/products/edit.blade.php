<x-dashboard.shop>
    @push('styles')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap-taginput/bootstrap-tag.css') }}">
        <style type="text/css">
            .voyager .nav-tabs>li.active>a:hover {
                background-color: #62a8ea !important;
            }

            .variant_img {
                height: 120px;
                width: 120px;
            }

            .bootstrap-tagsinput {
                width: 100% !important;
            }
        </style>
    @endpush
    @push('scripts')
        <script>
            $(document).ready(function() {
                //sectors
                $('#categories').select2();
                $('#categories').val({{ $product->categories->pluck('id') }});
                $('#categories').trigger('change');
                //types

            });
        </script>
        <script type="text/javascript" src="{{ asset('bootstrap-taginput/bootstrap-tag.js') }}"></script>
    @endpush

    <h3><span class="text-primary opacity-25"><i class="fa fa-shopping-bag" aria-hidden="true"></i></span>
        {!! __('words.dashboard_product_edit_title') !!}
    </h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body shadow-lg">
                    <form action="{{ route('shop.products.update', $product) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-6">
                                <x-form.input type="text" name="name" label="{!! __('words.dashboard_category_index_name') !!}"
                                    :value="old('name') ?? $product->name" />

                                <x-form.input type="text" name="slug" label="{!! __('words.dashboard_slug') !!}"
                                    :value="old('slug') ?? $product->slug" readonly />
                                <small class="text-info">
                                    {!! __('words.dashboard_slug_alert') !!}
                                </small>
                                <x-form.input type="text" name="ean" label="{!! __('words.dashboard_ean_code') !!}"
                                    :value="old('ean') ?? $product->ean" />
                                <x-form.input type="number" name="price" label="{!! __('words.cart_table_price') !!}"
                                    :value="old('price') ?? $product->price" />
                                <x-form.input type="number" name="saleprice" label="{!! __('words.dashboard_sale_price') !!}"
                                    :value="old('saleprice') ?? $product->saleprice" />
                                <x-form.input type="number" name="tax" label="{!! __('words.invoice_tax') !!} (%)"
                                    value="{{ old('tax', $product->tax) }}" />
                                <x-form.input type="text" name="sku" label="{!! __('words.dashboard_product_number') !!}"
                                    :value="old('sku') ?? $product->sku" />
                                <x-form.input type="textarea" id="description" name="description"
                                    label="{!! __('words.dashboard_description') !!}" :value="old('description') ?? $product->description" />
                                <x-form.input type="number" name="quantity" label="{!! __('words.dashboard_product_quantity') !!}"
                                    :value="old('quantity') ?? $product->quantity" />

                                <x-form.input type="file" name="image"
                                    label="{!! __('words.dashboard_product_image') !!} (400 X 400)" />
                                @if ($product->image)
                                    <div style="position: relative">
                                        <a href="#" class="delete-icon"
                                            onclick="deleteImage('products','{{ $product->image }}','{{ $product->id }}','image')">x</a>
                                        <img src="{{ Iziibuy::image($product->image) }}" alt="Product main image"
                                            height="100">
                                    </div>
                                @endif
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">

                                <x-form.input type="textarea" id="details" name="details"
                                    label="{!! __('words.dashboard_details') !!}" :value="old('details', $product->details)" />
                                <x-form.input type="file" :multiple="true" name="images[]"
                                    label="Images (400 X 400)" />
                                @if (!empty($product->images))
                                    <div style="position: relative">
                                        @foreach ($product->images as $image)
                                            <a href="#" class="delete-icon"
                                                onclick="deleteImage('products','{{ $image }}','{{ $product->id }}','image')">x</a>
                                            <img src="{{ Iziibuy::image($image) }}" alt="Product main image"
                                                height="100">
                                        @endforeach
                                    </div>

                                @endif
                              
                                <x-form.input type="checkbox" label="{!! __('words.dashboard_status') !!}" name="status"
                                    checked="{{ $product->status == 1 ? true : false }}" value="on" />
                                <x-form.input type="checkbox" label="{!! __('words.dashboard_product_featured') !!}" name="featured"
                                    checked="{{ $product->featured == 1 ? true : false }}" value="on" />
                                <x-form.input type="checkbox" label="{!! __('words.dashboard_variable') !!} ?" name="variable"
                                    checked="{{ $product->is_variable == 1 ? true : false }}" value="on" />
                                <x-form.input type="number" name="length" label="{!! __('words.dashboard_length') !!}"
                                    :value="old('length') ?? $product->length" />
                                <x-form.input type="number" name="width" label="{!! __('words.dashboard_width') !!}"
                                    :value="old('width') ?? $product->width" />
                                <x-form.input type="number" name="height" label="{!! __('words.dashboard_height') !!}"
                                    :value="old('height') ?? $product->height" />
                                <x-form.input type="text" name="weight" label="{!! __('words.dashboard_weight') !!}"
                                    :value="old('weight') ?? $product->weight" />
                                <x-form.input type="select" id="categories" name="categories[]"
                                    label="{!! __('words.products_category_sec_title') !!}" multiple="true" :options="$categories"
                                    selected="" />
                                <button class="btn btn-lg btn-primary"><i class="fa fa-plus-square"
                                        aria-hidden="true"></i> {!! __('words.dashboard_product_create_btn') !!}</button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>

        </div>
    </div>
    @if ($product->is_variable)


        <div class="row mt-2">
            <div class="col-md-12 ">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button
                                    class="nav-link {{ session()->get('target') == 'attribute' ? 'active' : ' ' }}"
                                    id="attribute-tab" data-bs-toggle="pill" data-bs-target="#attribute"
                                    type="button" role="tab" aria-controls="pills-attribute"
                                    aria-selected="true">{!! __('words.dashboard_attribute_btn') !!}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ session()->get('target') == 'attribute' ? 'active' : '' }}"
                                    id="pills-variable-tab" data-bs-toggle="pill"
                                    data-bs-target="#variable_product_id" type="button" role="tab"
                                    aria-controls="pills-variable"
                                    aria-selected="false">{!! __('words.dashboard_variation_btn') !!}</button>
                            </li>

                        </ul>


                        <div class="tab-content">
                            <div id="attribute"
                                class="tab-pane fade in  {{ session()->get('target') == 'attribute' ? 'active show' : '' }} ">

                                <div class="card">
                                    <div class="card-body">

                                        <form action="{{ route('shop.products.attribute.store') }}" method="post">
                                            @csrf

                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <div class="form-group">
                                                <label for="">{!! __('words.dashboard_attribute_key') !!}</label>
                                                <input type="text" class="form-control" name="attr_name"
                                                    placeholder="{!! __('words.dashboard_attribute_key_place') !!}" required />

                                            </div>
                                            <div class="form-group">
                                                <label for="">{!! __('words.dashboard_attribute_value') !!}</label>
                                                <input type="text" class="form-control" name="attr_value"
                                                    data-role="tagsinput" placeholder="{!! __('words.dashboard_attribute_value_place') !!}"
                                                    required="" value="">
                                            </div>
                                            <button type="submit"
                                                class="btn btn-primary">{!! __('words.dashboard_product_create_btn') !!}</button>
                                        </form>
                                    </div>
                                </div>


                                @foreach ($product->attributes as $product_attribute)
                                    <hr>
                                    <div class="card">
                                        <div class="card-body">
                                            <?php $attribute_value = implode(',', $product_attribute->value); ?>
                                            <form action="{{ route('shop.products.attribute.update') }}"
                                                method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="">Key</label>
                                                    <input type="text" class="form-control" name="attr_name"
                                                        placeholder="Color,Size etc" required=""
                                                        value="{{ str_replace('_', ' ', $product_attribute->name) }} ">
                                                    <input type="hidden" value="{{ $product_attribute->id }}"
                                                        name="attr_id">


                                                </div>
                                                <div class="form-group">
                                                    <label for="values">Value</label>
                                                    <input class="form-control" name="attr_value"
                                                        data-role="tagsinput"
                                                        placeholder="Attribute value comma seperated red,yellow,white etc"
                                                        value="{{ $attribute_value }}" required="" />
                                                </div>
                                                <button type="submit" class="btn btn-primary"> Update</button>
                                                <a href="{{ route('shop.products.attribute.destroy', $product_attribute->id) }}"
                                                    class="remove_button btn btn-danger"
                                                    onclick="cskDelete()">Remove</a>
                                            </form>

                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <div id="variable_product_id"
                                class="tab-pane  fade in  {{ session()->get('target') == 'attribute' ? 'active show' : '' }}">
                                <div class="card">
                                    <div class="card-body">
                                        <a href="{{ route('shop.products.variation.create', $product->id) }}"
                                            class="btn btn-primary">{!! __('words.dashboard_add_btn') !!}</a>
                                    </div>
                                </div>
                                <div id="accordion">
                                    @foreach ($product->subproducts as $variable_product)
                                        <div class="card" style="margin-top:10px">
                                            <div class="card-body">
                                                <form
                                                    action="{{ route('shop.products.variation.update', $variable_product->id) }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="card-body">
                                                        <div class="row">
                                                            @foreach ($product->attributes as $product_attribute)
                                                                <div class="col-md-2">
                                                                    <label
                                                                        for="{{ $product_attribute->name }}_id">{{ $product_attribute->name }}</label>
                                                                    <?php
                                                                    $name = $product_attribute->name;
                                                                    $csk = $variable_product->variation->$name ?? false;
                                                                    ?>
                                                                    <select class="form-control"
                                                                        name="variation[{{ $product_attribute->name }}]"
                                                                        id="{{ $product_attribute->name }}_id">
                                                                        @foreach ($product_attribute->value as $value)
                                                                            <option value="{{ $value }}"
                                                                                <?php if ($value == $csk) {
                                                                                    echo 'selected';
                                                                                } ?>>
                                                                                {{ $value }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            @endforeach
                                                            <div class="col-md-2" style="cursor: pointer;"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#variable_collaps{{ $variable_product->id }}"
                                                                aria-expanded="false"
                                                                aria-controls="variable_collaps">
                                                                <p><i class="fa fa-caret-down" aria-hidden="true"></i>
                                                                </p>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <x-qr.direct :size="150" :url="route('direct-order', [
                                                                    'user_name' => auth()->user()->getShop()
                                                                        ->user_name,
                                                                    'product' => $variable_product,
                                                                ])" />

                                                            </div>
                                                        </div>
                                                        <hr>

                                                        <div id="variable_collaps{{ $variable_product->id }}"
                                                            class="collapse" aria-labelledby="headingThree"
                                                            data-parent="#accordion">
                                                            <div class="row">
                                                                <div class="form-group  col-md-4 ">
                                                                    <label class="control-label"
                                                                        for="variable_price">{!! __('words.cart_table_price') !!}</label>
                                                                    <input type="number" step="any"
                                                                        class="form-control" name="variable_price"
                                                                        placeholder="Price" id="variable_price"
                                                                        value="{{ $variable_product->price }}"
                                                                        required>
                                                                </div>
                                                                <div class="form-group  col-md-4 ">
                                                                    <label class="control-label"
                                                                        for="variable_price">{!! __('words.dashboard_sale_price') !!}</label>
                                                                    <input type="number" step="any"
                                                                        class="form-control" name="saleprice"
                                                                        placeholder="Sale Price" id="variable_price"
                                                                        value="{{ $variable_product->saleprice }}">
                                                                </div>
                                                                <div class="form-group  col-md-4 ">
                                                                    <label class="control-label"
                                                                        for="variable_stock">{!! __('words.dashboard_product_instock') !!}</label>
                                                                    <input type="number" min="0"
                                                                        max="50000" step="any"
                                                                        class="form-control" name="variable_stock"
                                                                        placeholder="stock" id="variable_stock"
                                                                        value="{{ $variable_product->quantity }}"
                                                                        required>
                                                                </div>
                                                                <div class="form-group  col-md-4 ">
                                                                    <label class="control-label"
                                                                        for="variable_sku">{{ __('words.dashboard_sku') }}</label>
                                                                    <input type="text" class="form-control"
                                                                        name="variable_sku" id="variable_sku"
                                                                        value="{{ $variable_product->sku }}">
                                                                </div>
                                                                <div class="form-group  col-md-4 ">
                                                                    <label class="control-label"
                                                                        for="length">{!! __('words.dashboard_length') !!}</label>
                                                                    <input type="number" min="1"
                                                                        max="50000" step="any"
                                                                        class="form-control" name="length"
                                                                        placeholder="length" id="length"
                                                                        value="{{ $variable_product->length }}">
                                                                </div>
                                                                <div class="form-group  col-md-4 ">
                                                                    <label class="control-label"
                                                                        for="width">{!! __('words.dashboard_width') !!}</label>
                                                                    <input type="number" min="1"
                                                                        max="50000" step="any"
                                                                        class="form-control" name="width"
                                                                        placeholder="width" id="width"
                                                                        value="{{ $variable_product->width }}">
                                                                </div>
                                                                <div class="form-group  col-md-4 ">
                                                                    <label class="control-label"
                                                                        for="height">{!! __('words.dashboard_height') !!}</label>
                                                                    <input type="number" min="1"
                                                                        max="50000" step="any"
                                                                        class="form-control" name="height"
                                                                        placeholder="height" id="height"
                                                                        value="{{ $variable_product->height }}">
                                                                </div>
                                                                <div class="form-group  col-md-4 ">
                                                                    <label class="control-label"
                                                                        for="weight">{!! __('words.dashboard_weight') !!}</label>
                                                                    <input type="number" min="1"
                                                                        max="50000" step="any"
                                                                        class="form-control" name="weight"
                                                                        placeholder="weight" id="weight"
                                                                        value="{{ $variable_product->weight }}">
                                                                </div>
                                                                <div class="form-group  col-md-4 ">
                                                                    <label class="control-label"
                                                                        for="image">{!! __('words.dashboard_product_image') !!}</label>
                                                                    <input type="file" class="form-control"
                                                                        name="image" style="padding: 6px 12px">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    @if ($variable_product->image)
                                                                        <a href="#" class="delete-icon"
                                                                            onclick="deleteImage('products','{{ $variable_product->image }}','{{ $variable_product->id }}','image')">x</a>
                                                                        <img src="{{ Iziibuy::image($variable_product->image) }}"
                                                                            style="width:100px">
                                                                    @endif
                                                                </div>
                                                                <div class="form-group  col-md-12 mt-3 ">
                                                                    <button class="btn btn-sm btn-primary"
                                                                        type="submit">{!! __('words.dashboard_product_create_btn') !!}</button>


                                                                    <a class="btn btn-sm btn-success"
                                                                        href="{{ route('shop.products.variation.affiliate', $variable_product) }}">{!! __('words.manager_qr_code_btn') !!}</a>
                                                                    <x-helpers.delete :url="route(
                                                                        'shop.products.variation.destroy',
                                                                        $variable_product->id,
                                                                    )"
                                                                        :id="$variable_product->id" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
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

    @endif
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#description').summernote({
                    height: 200
                });
                $('#details').summernote({
                    height: 200
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#categories').select2();
            });
        </script>
        @if (session()->has('scroll'))
            <script type="text/javascript">
                var elmnt = document.getElementById("attribute_variation");
                elmnt.scrollIntoView();
            </script>
        @endif
    @endpush


</x-dashboard.shop>
