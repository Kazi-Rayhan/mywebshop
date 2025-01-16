<x-dashboard.shop>
    @push('styles')
        <style>
            .table td {
                vertical-align: middle
            }
        </style>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush
    <h3> <i class="fa fa-shopping-bag text-primary"></i> {!! __('words.dashboard_products_title') !!}</h3>

    <div class="d-flex justify-content-end">
        <a class="btn btn-primary" href="{{ route('shop.products.create') }}"><i class="fas fa-plus"></i>
            {!! __('words.dashboard_product_index_btn') !!}</a>
    </div>
    <div class="card my-3">
        <div class="card-body">
            <h4>
                {!! __('words.dashboard_import_products') !!}
            </h4>

            {{-- <form action="{{ route('shop.product.import') }}" method="post" enctype="multipart/form-data"> --}}
            <form action="{{ route('shop.product.import') }}" method="post" enctype="multipart/form-data">
                @csrf
              
                <div class="form-group">
                    <input type="file" class="form-control" name="sheet">
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
    @if (request('category'))
        <div class="card my-3">
            <div class="card-body">
                <h4>
                    {!! __('words.pinned_category_text') !!}
                </h4>
            </div>
        </div>
    @endif
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    {!! __('words.product_per_page') !!} <br>
                    <select name="" id="product_per_page" class="">
                        <option value="25" @if (request('paginate') == 25) selected @endif>25</option>
                        <option value="50" @if (request('paginate') == 50) selected @endif>50</option>
                        <option value="100" @if (request('paginate') == 100) selected @endif>100</option>
                        <option value="250" @if (request('paginate') == 250) selected @endif>250</option>
                    </select>

                    @if (request('pinned'))
                        <a class="btn btn-success float-right mr-2" href="{{ route('shop.products.index') }}"><i
                                class="fa fa-map-pin"></i>
                            {!! __('words.pinned_products') !!} </a>
                    @else
                        <a class="btn btn-danger float-right mr-2"
                            href="{{ route('shop.products.index', ['pinned' => 'pinned']) }}"><i
                                class="fa fa-map-pin"></i>
                            {!! __('words.pinned_products') !!} </a>
                    @endif
                </div>
                <div class="row m-1">


                    <div class="col-lg-4  col-md-4 col-sm-12">
                        <form action="" method="get">
                            <div class="form-group">
                                <label for="">{{ __('words.categories') }}</label>
                                <div class="input-group">
                                    <select class="form-control h-100 select2" name="category" id="">
                                        <option value=""> {{ __('words.all') }} </option>
                                        @foreach ($categories as $category)
                                            <option @if (request()->category == $category->id) selected @endif
                                                value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <button class="input-group-text btn-sm"
                                        id="basic-addon2">{!! __('words.apply') !!}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <form action="" method="get">
                            <div class="form-group">
                                <label for="">{{ __('words.search') }}</label>
                                <div class="input-group ">
                                    <input type="text" class="form-control" name="search"
                                        placeholder="{!! __('words.search') !!}">
                                    <button type="submit" class="input-group-text"
                                        id="basic-addon2">{!! __('words.search') !!}</button>
                                </div>
                            </div>

                        </form>

                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <form id="bulk" method="post" action="{{ route('shop.products.change_status') }}">
                            @csrf
                            <div class="form-group">
                                <label for="">{{ __('words.bulk_action') }}</label>
                                <div class="input-group">
                                    <select name="status" id="" class="form-control">
                                        <option value="" selected> {{ __('words.no') }} </option>
                                        <option value="1">{{ __('words.active') }}</option>
                                        <option value="0">{{ __('words.deactive') }}</option>
                                    </select>
                                    <button type="button" class="input-group-text"
                                        id="bulkbutton">{!! __('words.apply') !!}</button>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="card-body shadow-lg">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>


                                    <input type="checkbox" name="all">

                                </th>
                                <th>{!! __('words.dashboard_category_index_qr') !!}</th>
                                <th>{!! __('words.dashboard_category_index_name') !!}</th>
                                <th>{!! __('words.cart_table_price') !!}</th>
                                <th>{!! __('words.dashboard_status') !!}</th>
                                <th>{!! __('words.cart_table_action') !!}</th>
                                <th>{!! __('words.pin_by_category') !!}</th>
                            </tr>
                        </thead>
                        <tbody x-data="orderable" id="container">
                            @foreach ($products as $product)
                                <tr class="dragable" data-id="{{ $product->id }}" style="cursor: pointer">
                                    <td>
                                        <input type="checkbox" name="product[]" value="{{ $product->id }}">
                                    </td>
                                    <td>
                                        <x-qr.direct :size="100" :url="route('direct-order', [
                                            'user_name' => $product->shop->user_name,
                                            'product' => $product,
                                        ])" />
                                    </td>
                                    <td>
                                        {{ $product->name }} <br>
                                    </td>
                                    <td>
                                        @if ($product->saleprice)
                                            <h6><del
                                                    class="mr-2">{{ Iziibuy::price($product->price) }}</del>{{ Iziibuy::price($product->saleprice) }}
                                            </h6>
                                        @else
                                            <h6>{{ Iziibuy::price($product->price) }} </h6>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($product->status == 1)
                                            <span class="badge badge-primary">On</span>
                                        @else
                                            <span class="badge badge-danger">Off</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">

                                            <x-helpers.delete :url="route('shop.products.destroy', $product)" :id="$product->id" />
                                            <a class="btn btn-info btn-sm "
                                                href="{{ route('shop.products.edit', $product) }}"><i
                                                    class="fas fa-edit"></i></a>
                                            <a class="btn btn-info btn-sm "
                                                href="{{ route('shop.products.variation.affiliate', $product) }}"><i
                                                    class="fas fa-qrcode"></i></a>
                                            <a title="{{ $product->pin ? 'UnPin the product' : 'Pin the product' }}"
                                                class="btn btn-{{ $product->pin ? 'success' : 'danger' }} btn-sm "
                                                href="{{ route('shop.products.pin', $product->id) }}"><i
                                                    class="fa fa-map-pin"></i></a>
                                        </div>
                                    </td>
                                    <td>
                                        {{-- @foreach ($product->categories as $category)
                                            <a
                                                href="{{ route('shop.products.index', ['category' => $category->id]) }}">{{ $category->name }}</a>,
                                        @endforeach --}}
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>
                </form>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.3/dragula.min.js'></script>
        <script>
            $('#product_per_page').on('change', function() {
                var url = new URL(window.location.href);
                url.searchParams.set("paginate", this.value);
                window.location = url.href;
                //alert( this.value );
            });
        </script>
        <script>
            function orderable() {
                const container = document.getElementById('container');
                const rows = container.children;

                return {
                    formData: [],
                    update() {
                        this.formData = [];
                        this.nodeListForEach(rows, (index, row) => {
                            this.formData.push({
                                id: row.dataset.id,
                                order_no: row.dataset.rowPosition,
                            });
                        });

                        //console.log(this.formData)
                        $.ajax({
                            method: 'post',
                            url: "{{ route('shop.products.order') }}",
                            data: {
                                products: this.formData,
                                _token: "{{ csrf_token() }}"
                            },

                        })
                    },
                    nodeListForEach(array, callback, scope) {
                        for (let i = 0; i < array.length; i++) {
                            callback.call(scope, i, array[i]);
                        }
                    },
                    init() {
                        const sortableTable = dragula([container]);
                        sortableTable.on('dragend', () => {
                            this.nodeListForEach(rows, (index, row) => row.dataset.rowPosition = index + 1);
                            this.update();
                        });
                    },
                };
            }
        </script>
        <script>
            $(document).ready(function() {
                $('.select2').select2();
            });
            $('input[name="all"]').click(function(event) {
                if (event.target.checked) {
                    [...$('input[name="product[]"]')].map(el => {
                        $(el).prop('checked', true);
                    })
                } else {
                    [...$('input[name="product[]"]')].map(el => {
                        $(el).prop('checked', false);
                    })
                }
            })
            $('#bulkbutton').click(function() {
                $('#bulk').submit();
            })
        </script>
    @endpush
</x-dashboard.shop>
