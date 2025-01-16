<x-dashboard.shop>
    <h3><span class="text-primary opacity-25"><i class="fas fa-list" aria-hidden="true"></i></span>{!! __('words.shippping_index_sec_title') !!}
    </h3>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success float-right" href="{{ route('shop.shippings.create') }}"><i
                            class="fas fa-plus"></i> {!! __('words.shipping_create_btn') !!} </a>
                </div>
                <div class="card-body shadow-lg">

                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{!! __('words.shipping_method') !!}</th>
                                <th>{!! __('words.shipping_cost') !!}</th>

                                <th>{!! __('words.cart_table_action') !!}</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    0
                                </td>
                                <td>
                                    {!! strip_tags(__('words.pickup_from_store')) !!}
                                </td>
                                <td>
                                    {{ Iziibuy::price(0) }}
                                </td>
                                <td>

                                    @if ($shippings->count() > 0)
                                        <form class="form-inline" action="{{ route('shop.update.config') }}"
                                            method="post">
                                            @csrf
                                            <div class="form-group mx-sm-3 mb-2">

                                                <select name="toggle" id="store_as_pickup_point"
                                                    class="form-control">
                                                    <option value="0" @if(auth()->user()->shop->store_as_pickup_point == 0) selected @endif>{{ __('words.off') }}</option>
                                                    <option value="1" @if(auth()->user()->shop->store_as_pickup_point == 1) selected @endif>{{ __('words.on') }}</option>
                                                </select>
                                            </div>
                                            
                                            <button type="submit" class="btn btn-primary mb-2">
                                                Update</button>
                                        </form>
                                    @else
                                        <p>To switch this feature on or off, you must have <br> at least one shipping
                                            method other than this one. </p>
                                    @endif
                                </td>
                            </tr>
                            @foreach ($shippings as $shipping)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $shipping->shipping_method }}
                                    </td>
                                    <td>
                                        {{ Iziibuy::price($shipping->shipping_cost) }}
                                    </td>


                                    <td>
                                        <x-helpers.delete :url="route('shop.shippings.destroy', $shipping)" :id="$shipping->id" />
                                        <a class="btn btn-info btn-sm mt-1"
                                            href="{{ route('shop.shippings.edit', $shipping) }}"><i
                                                class="fas fa-edit"></i></a>
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

