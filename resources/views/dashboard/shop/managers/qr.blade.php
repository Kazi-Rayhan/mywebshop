<x-dashboard.shop>
    <h3>{{ __('words.qr_code_sec_title') }} {{ $user->name }}</h3>
    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">{{ __('words.dashboard_category_index_qr') }}</th>
                        <th scope="col">{{ __('words.qr_product_title') }}</th>
                        <th scope="col">{{ __('words.cart_table_action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <th scope="row">
                                <x-qr.direct :size="150" :url="route('direct-order', [
                                    'user_name' => auth()->user()->shop->user_name,
                                    $product,
                                    'manager_id' => $user->id,
                                ])" />

                            <th scope="row">
                                {{ $product->name }} <br>
                                @if ($product->variation)
                                    {{ json_encode($product->variation) }}
                                @endif
                            </th>
                            <th scope="row">
                                <a target="_blank"
                                    href="{{ route('direct-order', ['user_name' => auth()->user()->shop->user_name, $product, 'manager_id' => $user->id]) }}"
                                    class="btn btn-info btn-sm">Visit</a>
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



</x-dashboard.shop>
