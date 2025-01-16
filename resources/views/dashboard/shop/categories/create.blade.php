<x-dashboard.shop>


    <h3><span class="text-primary opacity-25"><i class="fa fa-list" aria-hidden="true"></i></span>
        {!! __('words.dashboard_category_create_title') !!}
    </h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body shadow-lg">
                    <form action="{{ route('shop.categories.store') }}" method="POST">
                        <div class="row">

                            @csrf
                            <div class="col-12">
                                <x-form.input id="name" type="text" name="name" label="{!! __('words.dashboard_category_index_name') !!}"
                                    value="{{ old('name') }}" />
                            </div>
                            <div class="col-4">
                                <x-form.input id="slug" type="text" name="slug" label="{!! __('words.dashboard_slug') !!}"
                                    value="{{ old('slug') }}" id="slug" />
                            </div>
                            <div class="col-4">
                                <x-form.input type="select" name="category" label="{!! __('words.dashboard_parent_category') !!}"
                                    :options="$categories" />
                            </div>
                            <div class="col-4">
                                <x-form.input type="number" name="order_no" label="{!! __('words.dashboard_order_no') !!}"
                                    value="{{ old('order_no') }}" />
                            </div>
                           
                        </div>
                     <button class="btn btn-primary"> <i class="fa fa-plus-square" aria-hidden="true"></i>
                                Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
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
