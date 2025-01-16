<x-dashboard.shop>
    <h3> <i class="fa fa-list text-primary"></i> {!! __('words.dashboard_category_sec_title') !!}</h3>


    @push('style')
       <style>
        .dragable {
            cursor: pointer;
        }

        .gu-transit {
            box-shadow: 2px 1px 8px grey
        }
    </style>
    @endpush

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success float-right" href="{{ route('shop.categories.create') }}"><i
                            class="fas fa-plus"></i>{!! __('words.dashboard_category_index_btn') !!} </a>
                </div>
                <div class="card-body shadow-lg">

                    <table class="table">
                        <thead>

                            <tr>
                                <th>{!! __('words.dashboard_category_index_qr') !!}</th>
                                <th>{!! __('words.dashboard_category_index_name') !!}</th>
                                <th>{!! __('words.cart_table_action') !!}</th>
                            </tr>
                        </thead>
                        <tbody x-data="orderable" id="container">
                            @foreach ($categories as $category)
                                <tr class="dragable" data-id="{{ $category->id }}">
                                    <td>
                                        <x-qr.direct :size="100" :qr="Iziibuy::image($category->qrcode)" :url="route('products', [
                                            auth()->user()->shop->user_name,
                                            'cateogry' => $category->slug,
                                        ])" />
                                    </td>
                                    </td>
                                    <td>
                                        {{ $category->name }}
                                    </td>
                                    <td>
                                        <x-helpers.delete :url="route('shop.categories.destroy', $category)" :id="$category->id" />
                                        <a class="btn btn-info btn-sm"
                                            href="{{ route('shop.categories.edit', $category) }}"><i
                                                class="fas fa-edit"></i></a>
                                        <a title="Product List" class="btn btn-info btn-sm"
                                            href="{{ route('shop.products.index', ['category' => $category->id]) }}"><i
                                                class="fa fa-play"></i></a>
                                    </td>
                                </tr>
                            @endforeach

                       
                        </tbody>
                    </table>
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
        @push('scripts')
        <script src='https://cdnjs.cloudflare.com/ajax/libs/dragula/3.7.3/dragula.min.js'></script>

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
                            url: "{{ route('shop.categories.order') }}",
                            data: {
                                categories: this.formData,
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
    @endpush

</x-dashboard.shop>
