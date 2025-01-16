<?php
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
$orders = Order::where('shop_id', $dataTypeContent->id)->get();
$thisMonth = Order::where('shop_id', $dataTypeContent->id)
    ->whereMonth('created_at', Carbon::now()->month)
    ->get();
$products = Product::where('shop_id', $dataTypeContent->id)
    ->whereNull('parent_id')
    ->get();
?>

@extends('voyager::master')
@section('page_title', __('voyager::generic.view') . ' ' . $dataType->getTranslatedAttribute('display_name_singular'))
@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i> {{ __('voyager::generic.viewing') }}
        {{ ucfirst($dataType->getTranslatedAttribute('display_name_singular')) }} &nbsp;

        @can('edit', $dataTypeContent)
            <a href="{{ route('voyager.' . $dataType->slug . '.edit', $dataTypeContent->getKey()) }}" class="btn btn-info">
                <i class="glyphicon glyphicon-pencil"></i> <span
                    class="hidden-xs hidden-sm">{{ __('voyager::generic.edit') }}</span>
            </a>
        @endcan

        @can('delete', $dataTypeContent)
            @if ($isSoftDeleted)
                <a href="{{ route('voyager.' . $dataType->slug . '.restore', $dataTypeContent->getKey()) }}"
                    title="{{ __('voyager::generic.restore') }}" class="btn btn-default restore"
                    data-id="{{ $dataTypeContent->getKey() }}" id="restore-{{ $dataTypeContent->getKey() }}">
                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.restore') }}</span>
                </a>
            @else
                <a href="javascript:;" title="{{ __('voyager::generic.delete') }}" class="btn btn-danger delete"
                    data-id="{{ $dataTypeContent->getKey() }}" id="delete-{{ $dataTypeContent->getKey() }}">
                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">{{ __('voyager::generic.delete') }}</span>
                </a>
            @endif
        @endcan
        @can('browse', $dataTypeContent)
            <a href="{{ route('voyager.' . $dataType->slug . '.index') }}" class="btn btn-warning">
                <i class="glyphicon glyphicon-list"></i> <span
                    class="hidden-xs hidden-sm">{{ __('voyager::generic.return_to_list') }}</span>
            </a>
        @endcan
        <a target="_blank" style="margin-right: 4px" href="{{ route('admin.shop_product_export_by_admin', $dataTypeContent->id) }}"
            title="browse" class="btn btn-sm btn-primary pull-right edit">
            <i class="voyager-dot-3"></i> <span class="hidden-xs hidden-sm">Export Products</span>
        </a>
        <a target="_blank" style="margin-right: 4px"
            href="{{ url('admin/products?key=shop_id&filter=equals&s=' . $dataTypeContent->user_name) }}" title="browse"
            class="btn btn-sm btn-warning pull-right edit">
            <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Product List</span>
        </a>

    </h1>
    @include('voyager::multilingual.language-selector')
@stop
@section('css')
    <style>
        .count {
            font-size: 36px;
            font-weight: bold;
        }
    </style>
@stop
@section('content')

    <div class="page-content read container-fluid">
        <div class="panel panel-default ">
            <div class="panel-body bg-info">
                <form action="{{ route('admin.product.import') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="shop_id" value="{{ $dataTypeContent->id }}">
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control  "
                            style="text-align:center;height:100px;display:flex;font-size:20px;" name="sheet">
                    </div>
                    <div class="btn-group ">
                        <button type="submit" class="btn btn-primary">
                            {!! __('words.dashboard_import') !!}
                        </button>
                        <a href="{{ asset('demo.xlsx') }}" class="btn btn-warning ml-2">
                            {!! __('words.dashboard_demo_sheet') !!}
                        </a>
                    </div>
                </form>
            </div>

        </div>


        <div class="row">
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding: 10px ;font-size: 18px;font-weight: bold;"> Total Orders</div>
                    <div class="panel-body">
                        <span class="count">{{ $orders->count() }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding: 10px ;font-size: 18px;font-weight: bold;"> Total Earning
                    </div>
                    <div class="panel-body">
                        <span class="count">{{ Iziibuy::withSymbol($orders->sum('total')) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding: 10px ;font-size: 18px;font-weight: bold;">This Month Orders
                    </div>
                    <div class="panel-body">
                        <span class="count">{{ $thisMonth->count() }}</span>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding: 10px ;font-size: 18px;font-weight: bold;">This Month Earning
                    </div>
                    <div class="panel-body">
                        <span class="count">{{ Iziibuy::price($thisMonth->sum('total')) }}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading" style="padding: 10px ;font-size: 18px;font-weight: bold;"> Total Products
                    </div>
                    <div class="panel-body">
                        <span class="count">{{ $products->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Single delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="delete_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                        aria-label="{{ __('voyager::generic.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('voyager::generic.delete_question') }}
                        {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="{{ route('voyager.' . $dataType->slug . '.index') }}" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-danger pull-right delete-confirm"
                            value="{{ __('voyager::generic.delete_confirm') }} {{ strtolower($dataType->getTranslatedAttribute('display_name_singular')) }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right"
                        data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('javascript')
    @if ($isModelTranslatable)
        <script>
            $(document).ready(function() {
                $('.side-body').multilingual();
            });
        </script>
    @endif
    <script>
        var deleteFormAction;
        $('.delete').on('click', function(e) {
            var form = $('#delete_form')[0];
            if (!deleteFormAction) {
                // Save form action initial value
                deleteFormAction = form.action;
            }

            form.action = deleteFormAction.match(/\/[0-9]+$/) ?
                deleteFormAction.replace(/([0-9]+$)/, $(this).data('id')) :
                deleteFormAction + '/' + $(this).data('id');

            $('#delete_modal').modal('show');
        });
    </script>
@stop
