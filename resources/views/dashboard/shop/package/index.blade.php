<x-dashboard.shop>
    <h3><span class="text-primary opacity-25">{{ __('words.packages') }}</span> </h3>
    <div class="container">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success float-right" href="{{ route('shop.packages.create') }}"><i
                            class="fas fa-plus"></i>
                        {!! __('words.create_package') !!} </a>
                </div>
                <div class="card-body">

                    <div class="table-responsive">


                        @if ($package_option)
                            <table class="table">

                                <thead>

                                    <tr>
                                        <th>#</th>

                                        <th>{{ __('words.name') }}</th>
                                        <th>{{ __('words.sessions') }}</th>
                                        <th>{{ __('words.price') }}</th>

                                        <th>{{ __('words.table_actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($packages as $package)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $package->title }}
                                            </td>
                                            <td>
                                                {{ $package->sessions }}
                                            </td>
                                            <td>
                                                <ol>
                                                    @foreach ($package->levels->pluck('pivot.price', 'title') as $level => $price)
                                                        <li>
                                                            {{ ucwords($level) }} = {{ Iziibuy::price($price) }}
                                                        </li>
                                                    @endforeach
                                                </ol>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <x-helpers.delete
                                                        url="{{ route('shop.packages.destroy', $package->id) }}"
                                                        id="{{ $package->id }}" />

                                                    <a href="{{ route('shop.packages.edit', $package->id) }}"
                                                        class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h2>
                                {{ __('words.you_have_to_create_session_types_first_before_creating_a_session') }}
                            </h2>
                        @endif
                    </div>


                </div>

            </div>
        </div>


    </div>
    </div>
</x-dashboard.shop>
