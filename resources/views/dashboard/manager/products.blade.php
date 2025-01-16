<x-dashboard.manager>
    <h3>{{ __('words.manager_products_sec_title') }} </h3>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">{{ __('words.dashboard_category_index_qr') }}</th>
                        <th scope="col">{{ __('words.cart_table_product') }}
                            {{ __('words.subscription_index_title') }}
                        </th>
                        <th scope="col">{{ __('words.cart_table_action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3">
                            <form action="" method="get">
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="text" name="q" class="form-control" value="{{request()->q}}"
                                            placeholder="Search ....">
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary" title="serach">
                                            <i class="fa fa-search" aria-hidden="true"></i>
                                        </button>
                                        <a href="{{ url()->current() }}"class="btn btn-warning" title="reset">
                                            <i class="fa fa-recycle" aria-hidden="true"></i>
                                        </a>
                                    </div>

                            </form>
        </div>
        </td>
        </tr>
        @foreach ($products as $product)
            <tr>
                <th scope="row">
                    <x-qr.direct :size="150" :url="route('direct-order', [
                        'user_name' => auth()->user()->getShop()->user_name,
                        'product' => $product,
                        'manager_id' => auth()->id(),
                    ])" />

                </th>

                <th scope="row">
                    {{ $product->name }} <br>
                    @if ($product->variation)
                        {{ json_encode($product->variation) }}
                    @endif
                </th>
                <th scope="row">
                    <a target="_blank"
                        href="{{ route('direct-order', ['user_name' => auth()->user()->getShop()->user_name, 'product' => $product, 'manager_id' => auth()->id()]) }}"
                        class="btn btn-info btn-sm">{{ __('words.visit_btn') }}</a>
                </th>
            </tr>
        @endforeach
        <tr>
            <td colspan="3">
                {{ $products->links() }}
            </td>
        </tr>
        </tbody>
        </table>
    </div>
    </div>
</x-dashboard.manager>
