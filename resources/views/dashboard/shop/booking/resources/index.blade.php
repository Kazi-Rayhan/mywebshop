<x-dashboard.shop>
    @push('styles')
        <style>
            .table td {
                vertical-align: middle
            }

        </style>
    @endpush
    
    <h3><span class="text-primary opacity-25"><i class="fas fa-list" aria-hidden="true"></i></span> {{ __('words.resourse_sec_title') }}
    </h3>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success float-right" href="{{ route('shop.booking.resources.create') }}"><i class="fas fa-plus"></i> {{ __('words.resourse_create_btn') }} </a>
                </div>
                <div class="card-body shadow-lg">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('words.resourse') }}</th>
                                <th>{{ __('words.resourse_qnty') }}</th>
                                <th>{{ __('words.cart_table_action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($resources as $resource)
                                <tr>
                                    <td>{{ $resource->name }}</td>
                                    <td>{{ $resource->available_seats }}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm mt-1" href="{{ route('shop.booking.resources.edit', $resource) }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm mt-1" href="{{ route('shop.booking.resources.destroy', $resource) }}" onclick="cskDelete(this.href)">
                                            <i class="fas fa-trash"></i>
                                        </a>
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
