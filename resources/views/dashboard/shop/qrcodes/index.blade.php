<x-dashboard.shop>
    <h3><span class="text-primary opacity-25"><i class="fas fa-list" aria-hidden="true"></i></span> {!! __('words.qrcodes') !!}
    </h3>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <a href="{{ route('shop.qrcodes.create') }}" class="btn btn-primary"> <i class="fa fa-plus"></i>
                    {{ __('wrods.add_qrcode') }}</a>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>
                                #
                            </th>
                            <th class="text-center">
                                {{ __('words.qrcode') }}
                            </th>
                            <th>
                                {{__('words.mailchimp_list_id')}}
                            </th>
                            <th>
                                {{ __('words.visits') }}
                            </th>
                            
                            <th>
                                {{ __('words.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($codes as $code)
                            <td>
                                {{ $code->id }}
                            </td>
                            <td>
                                <x-qr.direct :size="80" :url="route('trainers.list', [
                                    'user_name' => auth()
                                        ->user()
                                        ->getShop()->user_name,
                                    'group' => $code->group,
                                ])" />
                            </td>
                            <td>
                                {{$code->group}}
                            </td>
                            <td>
                                {{ $code->count }}
                            </td>
                            <td>
                                <a href="{{route('shop.qrcodes.edit',$code)}}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                <x-helpers.delete :url="route('shop.qrcodes.destroy', $code)" :id="$code->id" />


                            </td>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>
    </div>
</x-dashboard.shop>
