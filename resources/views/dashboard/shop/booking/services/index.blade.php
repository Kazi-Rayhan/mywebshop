<x-dashboard.shop>
    @push('styles')
        <style>
            .table td {
                vertical-align: middle
            }

        </style>
    @endpush
    
    <h3><span class="text-primary opacity-25"><i class="fas fa-list" aria-hidden="true"></i></span>{{__('words.service_index_sec_title')}}
    </h3>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success float-right" href="{{ route('shop.booking.services.create') }}"><i
                            class="fas fa-plus"></i> {{ __('words.service_create_btn') }} </a>
                </div>
                <div class="card-body shadow-lg">

                    <table class="table">
                        <thead>
                            <tr>

                                <th>{{ __('words.dashboard_category_index_name') }}</th>

                                <th>{{ __('words.cart_table_action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                                <tr>
                                    <td><a>{{ $service->name }}</a></td>

                                    <td>

                                        <a class="btn btn-info btn-sm mt-1" href="{{route('shop.booking.services.edit',$service)}}"><i class="fas fa-edit"></i></a>
                                        <x-helpers.delete :url="route('shop.booking.services.destroy', $service)" :id="$service->id" />
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
