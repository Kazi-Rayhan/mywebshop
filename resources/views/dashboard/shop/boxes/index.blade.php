<x-dashboard.shop>
  
    <h3><span class="text-primary opacity-25"><i class="fas fa-list" aria-hidden="true"></i></span>{!! __('words.subscription_index_sec_title') !!}
    </h3>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success float-right" href="{{ route('shop.boxes.create') }}"><i
                            class="fas fa-plus"></i> {!! __('words.subscription_index_sec_title') !!} </a>
                </div>
                <div class="card-body shadow-lg">

                    <table class="table">
                        <thead>

                            <tr>
                                <th>{!! __('words.subscription_index_title') !!}</th>
                                <th>{!! __('words.cart_table_price') !!}</th>
                                <th>{!! __('words.products_count') !!}</th>
                                <th>{!! __('words.cart_table_action') !!}</th>
                            </tr>
                        </thead>
                        <tbody id="container">
                            @foreach ($boxes as $box)
                                <tr>
                                    <td>
                                        {{ $box->title }}
                                    </td>
                                    <td>{{ $box->price }}</td>
                                    <td>{{ $box->products_count }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a class="btn btn-success btn-sm"
                                                href="{{ route('shop.boxes.edit', $box) }}">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{ route('shop.boxes.show', $box) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <x-helpers.delete :url="route('shop.boxes.destroy', $box)" :id="$box->id" />


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
