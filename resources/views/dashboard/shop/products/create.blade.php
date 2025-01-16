<x-dashboard.shop>


    <h3><span class="text-primary opacity-25"><i class="fa fa-shopping-bag" aria-hidden="true"></i></span>
        {!! __('words.dashboard_poroduct_create_title') !!}
    </h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body shadow-lg">
                    <form action="{{ route('shop.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-6">
                                <x-form.input type="text" id="name" name="name"
                                    label="{!! __('words.dashboard_category_index_name') !!}" value="{{ old('name') }}" />

                                <x-form.input type="text" id="slug" name="slug"
                                    label="{!! __('words.dashboard_slug') !!}" value="{{ old('slug') }}" />
                                <small class="text-info">
                                    {!! __('words.dashboard_slug_alert') !!}
                                </small>
                                <x-form.input type="text" name="ean" label="{!! __('words.dashboard_ean_code') !!}"
                                    value="{{ old('ean') }}" />
                                <x-form.input type="number" name="price" label="{!! __('words.cart_table_price') !!}"
                                    value="{{ old('price') }}" min="0" />
                                <x-form.input type="number" name="saleprice" label="{!! __('words.dashboard_sale_price') !!}"
                                    value="{{ old('saleprice') }}" />
                                <x-form.input type="number" name="tax" label="{!! __('words.invoice_tax') !!} (%)"
                                    value="{{ old('tax') }}" />
                                <x-form.input type="text" name="sku" label="{!! __('words.dashboard_product_number') !!}"
                                    value="{{ old('sku') }}" />
                                <x-form.input type="textarea" name="description" id="description" label="{!! __('words.dashboard_description') !!}"
                                    value="{{ old('description') }}" />

                                <x-form.input type="number" name="quantity" label="{!! __('words.dashboard_product_quantity') !!}"
                                    value="{{ old('quantity') }}" />
                                <x-form.input type="file" name="image"
                                    label="{!! __('words.dashboard_product_image') !!} (400 X 400)" />
                            </div>
                            <div class="col-12 col-md-12 col-lg-6">
                                <x-form.input type="textarea" name="details" id="details" label="{!! __('words.dashboard_details') !!}"
                                    value="{{ old('details') }}" />
                                <x-form.input type="file" :multiple="true" name="images[]"
                                    label="Images (400 X 400)" />

                                <x-form.input type="checkbox" label="{!! __('words.dashboard_status') !!}" name="status"
                                    checked="{{ old('status') == 'on' ? true : false }}" value="on" />
                                <x-form.input type="checkbox" label="{!! __('words.dashboard_product_featured') !!}" name="featured"
                                    checked="{{ old('featured') == 'on' ? true : false }}" value="on" />
                                <x-form.input type="checkbox" label="{!! __('words.dashboar d_variable') !!} ?" name="variable"
                                    checked="{{ old('variable') == 'on' ? true : false }}" value="on" />
                                <x-form.input type="number" name="length" label="{!! __('words.dashboard_length') !!}"
                                    value="{{ old('length') }}" />
                                <x-form.input type="number" name="width" label="{!! __('words.dashboard_width') !!}"
                                    value="{{ old('width') }}" />
                                <x-form.input type="number" name="height" label="{!! __('words.dashboard_height') !!}"
                                    value="{{ old('height') }}" />
                                <x-form.input type="text" name="weight" label="{!! __('words.dashboard_weight') !!}"
                                    value="{{ old('weight') }}" />
                                <x-form.input type="select" id="categories" name="{{ 'categories[]' }}"
                                    label="{!! __('words.products_category_sec_title') !!}" :multiple="true" :options="$categories"
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
    @push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" integrity="sha512-ZbehZMIlGA8CTIOtdE+M81uj3mrcgyrh6ZFeG33A4FHECakGrOsTPlPQ8ijjLkxgImrdmSVUHn1j+ApjodYZow==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush
    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js" integrity="sha512-lVkQNgKabKsM1DA/qbhJRFQU8TuwkLF2vSN3iU/c7+iayKs08Y8GXqfFxxTZr1IcpMovXnf2N/ZZoMgmZep1YQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#description').summernote({
                    height: 300
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
        <script>
            $('#name').keyup(function() {
                $('#slug').val(slug($(this).val()));
            });

            function slug(str) {
                str = str.replace(/^\s+|\s+$/g, ''); // trim
                str = str.toLowerCase();

                // remove accents, swap ñ for n, etc
                var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
                var to = "aaaaaeeeeeiiiiooooouuuunc------";
                for (var i = 0, l = from.length; i < l; i++) {
                    str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
                }

                str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
                    .replace(/\s+/g, '-') // collapse whitespace and replace by -
                    .replace(/-+/g, '-'); // collapse dashes

                return "{{ auth()->user()->shop->user_name . '-' }}" + str;
            };
        </script>
    @endpush


</x-dashboard.shop>
