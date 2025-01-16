<x-dashboard.shop>

<h3><span class="text-primary opacity-25"><i class="fas fa-list" aria-hidden="true"></i></span>
        {{ __('words.levels_sec_title') }}
    </h3>

    <div class="row mt-5">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success float-right" href="{{ route('shop.levels.create') }}"><i
                            class="fas fa-plus"></i> {{ __('words.group_create_btn') }} </a>
                </div>
                <div class="card-body shadow-lg">

                    <table class="table">
                        <thead>
                            <tr>
                                <th>{{ __('words.dashboard_category_index_name') }}</th>
                                <th>{{ __('words.dashboard_commission') }}</th>
                                <th>{{ __('words.cart_table_action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($levels as $level)
                                <tr>
                                    <td>{{ $level->title }}</td>
                                    <td>{{ $level->commission }}</td>
                                    <td>
                                        <a class="btn btn-info btn-sm mt-1"
                                            href="{{ route('shop.levels.edit', $level) }}"><i
                                                class="fas fa-edit"></i></a>

                                        <x-helpers.delete :url="route('shop.levels.destroy', $level)" :id="$level->id" />

                                    </td>
                                </tr>
                            @endforeach
    


                        </tbody>
                    </table>
                    {{$levels->links()}}
                </div>
            </div>
        </div>
    </div>
</x-dashboard.shop>