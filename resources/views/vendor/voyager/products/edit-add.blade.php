@php
    $edit = !is_null($dataTypeContent->getKey());
    $add = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('voyager::generic.' . ($edit ? 'edit' : 'add')) . ' ' .
    $dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.' . ($edit ? 'edit' : 'add')) . ' ' . $dataType->getTranslatedAttribute('display_name_singular') }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form" class="form-edit-add"
                        action="{{ $edit ? route('voyager.' . $dataType->slug . '.update', $dataTypeContent->getKey()) : route('voyager.' . $dataType->slug . '.store') }}"
                        method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                        @if ($edit)
                            {{ method_field('PUT') }}
                        @endif

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Adding / Editing -->
                            @php
                                $dataTypeRows = $dataType->{$edit ? 'editRows' : 'addRows'};
                            @endphp

                            @foreach ($dataTypeRows as $row)
                                <!-- GET THE DISPLAY OPTIONS -->
                                @php
                                    $display_options = $row->details->display ?? null;
                                    if ($dataTypeContent->{$row->field . '_' . ($edit ? 'edit' : 'add')}) {
                                        $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field . '_' . ($edit ? 'edit' : 'add')};
                                    }
                                @endphp
                                @if (isset($row->details->legend) && isset($row->details->legend->text))
                                    <legend class="text-{{ $row->details->legend->align ?? 'center' }}"
                                        style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">
                                        {{ $row->details->legend->text }}</legend>
                                @endif

                                <div class="form-group @if ($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}"
                                    @if (isset($display_options->id)) {{ "id=$display_options->id" }} @endif>
                                    {{ $row->slugify }}
                                    <label class="control-label"
                                        for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                    @include('voyager::multilingual.input-hidden-bread-edit-add')
                                    @if (isset($row->details->view))
                                        @include($row->details->view, [
                                            'row' => $row,
                                            'dataType' => $dataType,
                                            'dataTypeContent' => $dataTypeContent,
                                            'content' => $dataTypeContent->{$row->field},
                                            'action' => $edit ? 'edit' : 'add',
                                            'view' => $edit ? 'edit' : 'add',
                                            'options' => $row->details,
                                        ])
                                    @elseif ($row->type == 'relationship')
                                        @include('voyager::formfields.relationship', [
                                            'options' => $row->details,
                                        ])
                                    @else
                                        {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                    @endif

                                    @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                        {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                    @endforeach
                                    @if ($errors->has($row->field))
                                        @foreach ($errors->get($row->field) as $error)
                                            <span class="help-block">{{ $error }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach
                            @if (!$edit)
                                <div class="form-group col-md-12">
                                    <h4>Categories</h4>
                                    @foreach ($categories as $category)
                                        <div class="checkbox">
                                            <label>
                                                <input
                                                    {{ $dataTypeContent->categories->contains($category->id) ? 'checked' : '' }}
                                                    name="categories[]" type="checkbox" value="{{ $category->id }}">
                                                {{ $category->name }}
                                            </label>
                                        </div>
                                        @foreach ($category->childrens as $children)
                                            <div class="checkbox" style="margin-left:20px">
                                                <label>
                                                    <input
                                                        {{ $dataTypeContent->categories->contains($children->id) ? 'checked' : '' }}
                                                        name="categories[]" type="checkbox" value="{{ $children->id }}">
                                                    {{ $children->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>
                            @endif

                            @if ($edit)
                                <div class="col-md-12">
                                    <h3>
                                        Prices
                                    </h3>
                                    <x-area :product="$dataTypeContent" />

                                </div>
                            @endif
                        </div><!-- panel-body -->

                        <div class="panel-footer">
                        @section('submit-buttons')
                            <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                        @stop
                        @yield('submit-buttons')
                    </div>
                </form>

                <iframe id="form_target" name="form_target" style="display:none"></iframe>
                <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                    enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                    <input name="image" id="upload_file" type="file"
                        onchange="$('#my_form').submit();this.value='';">
                    <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                    {{ csrf_field() }}
                </form>

            </div>
        </div>
    </div>
</div>
<div id="attribute_variation"></div>
@if ($dataTypeContent->is_variable && $dataTypeContent->id)
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-push-2">
                <div class="panel panel-bordered">
                    <ul class="nav nav-tabs">
                        <li class="<?php if (session()->get('target') == 'attribute') {
                            echo 'active';
                        } ?>"><a data-toggle="tab" href="#attribute"
                                class="text-primary">Attribute </a></li>
                        <li class="<?php if (session()->get('target') == 'variation') {
                            echo 'active';
                        } ?>"><a data-toggle="tab" href="#variable_product_id"
                                id="variation_btn">Variation</a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="attribute" class="tab-pane fade in <?php if (session()->get('target') == 'attribute') {
                            echo 'active';
                        } ?>">
                            <form action="{{ route('admin.store.attribute') }}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="product_id" value="{{ $dataTypeContent->id }}">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="attr_name"
                                        placeholder="Color,Size etc" required />
                                    <input style="" type="text" class="form-control" name="attr_value"
                                        data-role="tagsinput"
                                        placeholder="Attribute value comma seperated red,yellow,white etc"
                                        required="" value=""> <br>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                            @foreach ($product_attributes as $product_attribute)
                                <?php $attribute_value = implode(',', $product_attribute->value); ?>
                                <form action="{{ route('admin.update.attribute') }}" method="post">
                                    @csrf
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="attr_name"
                                            placeholder="Color,Size etc" required=""
                                            value="{{ $product_attribute->name }}">
                                        <input type="hidden" value="{{ $product_attribute->id }}" name="attr_id">
                                        <input class="form-control" name="attr_value" data-role="tagsinput"
                                            placeholder="Attribute value comma seperated red,yellow,white etc"
                                            value="{{ $attribute_value }}" required="" /> <br>
                                        <button type="submit" class="btn btn-primary"> Update</button>
                                        <a href="{{ route('admin.delete.product.attribute', $product_attribute->id) }}"
                                            class="remove_button btn btn-danger" onclick="cskDelete()">Remove</a>
                                    </div>
                                </form>
                            @endforeach
                        </div>
                        <div id="variable_product_id" class="tab-pane fade in <?php if (session()->get('target') == 'variation') {
                            echo 'active';
                        } ?>">
                            <a href="{{ route('admin.new.variation', $dataTypeContent->id) }}"
                                class="btn btn-primary">Add New</a>
                            <div id="accordion">
                                @foreach ($dataTypeContent->subproducts as $variable_product)
                                    <div class="card" style="margin-top:10px">
                                        <form action="{{ route('admin.update.variation', $variable_product->id) }}"
                                            method="post" enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="card-header" id="headingThree">
                                                <div class="col-md-11">
                                                    @foreach ($product_attributes as $product_attribute)
                                                        <?php
                                                        $name = $product_attribute->name;
                                                        $csk = $variable_product->variation->$name ?? false;
                                                        ?>
                                                        <select name="variation[{{ $product_attribute->name }}]"
                                                            id="">
                                                            @foreach ($product_attribute->value as $value)
                                                                <option value="{{ $value }}"
                                                                    <?php if ($value == $csk) {
                                                                        echo 'selected';
                                                                    } ?>>{{ $value }}</option>
                                                            @endforeach
                                                        </select>
                                                    @endforeach
                                                </div>
                                                <div class="col-md-1" style="cursor: pointer;" data-toggle="collapse"
                                                    data-target="#variable_collaps{{ $variable_product->id }}"
                                                    aria-expanded="false" aria-controls="variable_collaps">
                                                    <p> <i class="voyager-sort-desc"></i></p>
                                                </div>
                                            </div>
                                            <div id="variable_collaps{{ $variable_product->id }}" class="collapse"
                                                aria-labelledby="headingThree" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="form-group  col-md-4 ">
                                                        <label class="control-label"
                                                            for="variable_price">Price</label>
                                                        <input type="number"min="1" max="50000"
                                                            step="any" class="form-control" name="variable_price"
                                                            placeholder="Price" id="variable_price"
                                                            value="{{ $variable_product->price }}" required>
                                                    </div>
                                                    <div class="form-group  col-md-4 ">
                                                        <label class="control-label" for="variable_price">Sale
                                                            Price</label>
                                                        <input type="number" min="1" max="50000"
                                                            step="any" class="form-control" name="saleprice"
                                                            placeholder="Sale Price" id="variable_price"
                                                            value="{{ $variable_product->saleprice }}">
                                                    </div>
                                                    <div class="form-group  col-md-4 ">
                                                        <label class="control-label"
                                                            for="variable_stock">Instock</label>
                                                        <input type="number" min="1" max="50000"
                                                            step="any" class="form-control" name="variable_stock"
                                                            placeholder="stock" id="variable_stock"
                                                            value="{{ $variable_product->quantity }}">
                                                    </div>
                                                    <div class="form-group  col-md-4 ">
                                                        <label class="control-label" for="variable_sku">Sku</label>
                                                        <input type="text" class="form-control"
                                                            name="variable_sku" placeholder="sku" id="variable_sku"
                                                            value="{{ $variable_product->sku }}">
                                                    </div>
                                                    <div class="form-group  col-md-4 ">
                                                        <label class="control-label" for="image">Image</label>
                                                        <input type="file" class="form-control" name="image"
                                                            style="padding: 6px 12px">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <img src="{{ Tendenz::image($variable_product->image) }}"
                                                            style="width:100px">
                                                    </div>
                                                    <div class="form-group  col-md-12 ">
                                                        <button class="btn btn-primary" type="submit">Save</button>
                                                        <a href="{{ route('admin.delete.product.meta', $variable_product->id) }}"
                                                            class="btn btn-danger" onclick="cskDelete()">Delete</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
<div class="modal fade modal-danger" id="confirm_delete_modal">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}
                </h4>
            </div>

            <div class="modal-body">
                <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                    data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                <button type="button" class="btn btn-danger"
                    id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
            </div>
        </div>
    </div>
</div>

<!-- End Delete File Modal -->
@stop

@section('javascript')
<script>
    [...document.getElementsByClassName('toggle-area')].forEach(el => {
        el.addEventListener('click', function(event) {

            if (event.target.checked) {
                [...document.getElementsByClassName(event.target.dataset.class)].forEach(el => {
                    el.disabled = false
                })
            } else {
                [...document.getElementsByClassName(event.target.dataset.class)].forEach(el => {

                    el.disabled = true
                })
            }
        })
    })
</script>
<script>
    var params = {};
    var $file;

    function deleteHandler(tag, isMulti) {
        return function() {
            $file = $(this).siblings(tag);

            params = {
                slug: '{{ $dataType->slug }}',
                filename: $file.data('file-name'),
                id: $file.data('id'),
                field: $file.parent().data('field-name'),
                multi: isMulti,
                _token: '{{ csrf_token() }}'
            }

            $('.confirm_delete_name').text(params.filename);
            $('#confirm_delete_modal').modal('show');
        };
    }

    $('document').ready(function() {
        $('.toggleswitch').bootstrapToggle();

        //Init datepicker for date fields if data-datepicker attribute defined
        //or if browser does not handle date inputs
        $('.form-group input[type=date]').each(function(idx, elt) {
            if (elt.hasAttribute('data-datepicker')) {
                elt.type = 'text';
                $(elt).datetimepicker($(elt).data('datepicker'));
            } else if (elt.type != 'date') {
                elt.type = 'text';
                $(elt).datetimepicker({
                    format: 'L',
                    extraFormats: ['YYYY-MM-DD']
                }).datetimepicker($(elt).data('datepicker'));
            }
        });

        @if ($isModelTranslatable)
            $('.side-body').multilingual({
                "editing": true
            });
        @endif

        $('.side-body input[data-slug-origin]').each(function(i, el) {
            $(el).slugify();
        });

        $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
        $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
        $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
        $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

        $('#confirm_delete').on('click', function() {
            $.post('{{ route('voyager.' . $dataType->slug . '.media.remove') }}', params, function(
                response) {
                if (response &&
                    response.data &&
                    response.data.status &&
                    response.data.status == 200) {

                    toastr.success(response.data.message);
                    $file.parent().fadeOut(300, function() {
                        $(this).remove();
                    })
                } else {
                    toastr.error("Error removing file.");
                }
            });

            $('#confirm_delete_modal').modal('hide');
        });
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@if (session()->has('scroll'))
    <script type="text/javascript">
        var elmnt = document.getElementById("attribute_variation");
        elmnt.scrollIntoView();
    </script>
@endif
@stop
