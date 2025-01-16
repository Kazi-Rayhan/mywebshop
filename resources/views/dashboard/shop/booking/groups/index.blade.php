<x-dashboard.shop>
    @push('styles')
        <style>
            .table td {
                vertical-align: middle
            }

        </style>
    @endpush
    
    <h3><span class="text-primary opacity-25"><i class="fas fa-list" aria-hidden="true"></i></span> {{ __('words.group_sec_title') }}
    </h3>

    <div class="row mt-5">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success float-right" href="{{ route('shop.booking.price-groups.create') }}"><i
                            class="fas fa-plus"></i> {{ __('words.group_create_btn') }} </a>
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
                            @foreach ($groups as $group)
                                <tr>
                                    <td>{{ $group->name }}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm mt-1"
                                            href="{{ route('shop.booking.price-groups.edit', $group) }}"><i
                                                class="fas fa-edit"></i></a>
                                        <x-helpers.delete :url="route('shop.booking.price-groups.destroy', $group)" :id="$group->id" />
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
