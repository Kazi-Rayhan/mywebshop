<x-dashboard.shop>
    <h3>{!! __('words.store_index_sec_title') !!}</h3>

    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <td colspan="5">
                                    <a href="{{ route('shop.storage.create') }}"
                                        class="btn btn-primary btn-sm">{!! __('words.store_create_btn') !!}</a>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    {!! __('words.city') !!}
                                </th>
                                <th>
                                    {!! __('words.state') !!}
                                </th>
                                <th>
                                    {!! __('words.invoice_postcode') !!}
                                </th>
                                <th>
                                    {!! __('words.invoice_address') !!}
                                </th>
                                <th>
                                    {!! __('words.cart_table_action') !!}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($storages as $store)
                                <tr>
                                    <td>
                                        {{ $store->city }}
                                    </td>
                                    <td>
                                        {{ $store->state }}
                                    </td>
                                    <td>
                                        {{ $store->post_code }}
                                    </td>
                                    <td>
                                        {{ $store->address }}
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('shop.storage.show', $store) }}"
                                                class="btn btn-sm btn-outline-primary"><i class="fa fa-eye"
                                                    aria-hidden="true"></i></a>
                                            <a href="{{ route('shop.storage.edit', $store) }}"
                                                class="btn btn-sm btn-outline-info"><i class="fa fa-edit"
                                                    aria-hidden="true"></i></a>
                                            <x-helpers.delete :url="route('shop.storage.destroy', $store)" :id="$store->id" />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.shop>
