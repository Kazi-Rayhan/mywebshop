<x-dashboard.shop>

<h3><span class="text-primary opacity-25">{{ __('words.options') }}</span> </h3>
    <div class="container">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success float-right" href="{{ route('shop.packageoptions.create') }}"><i
                            class="fas fa-plus"></i>
                        {!! __('words.create_option') !!} </a>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('words.name') }}</th>
                                    <th>{{ __('words.minutes') }}</th>
                                    <th>{{ __('words.table_actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($options as $option)
                                
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $option->title }} @if($option->default)<span class="badge badge-primary">Default</span>@endif
                                            
                                        </td>
                                        <td>
                                            {{ $option->minutes }}
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <x-helpers.delete url="{{ route('shop.packageoptions.destroy', $option) }}"
                                                    id="{{ $option->id }}" />
                                                <a href="{{ route('shop.packageoptions.edit',$option) }}" class="btn btn-info btn-sm"><i
                                                class="fas fa-edit"></i></a>
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
    </div>
    </div>
</x-dashboard.shop>