<x-dashboard.retailer>


    <div class="container">
        <div class="card">
            <div class="card-body">
                <h3 class="d-print-none"><span
                        class="text-primary opacity-25 ">{{ __('words.sub_retailers_list') }}</span></h3>
              
                <a href="{{ route('retailer.createAffiliates') }}" class="btn btn-primary my-2">{{__('words.add_new_retailer')}}</a>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        {{ __('words.qrCode') }}
                                    </th>
                                    <th>
                                        {{ __('words.name') }}
                                    </th>
                                    <th>
                                        {{ __('words.email') }}
                                    </th>
                                    <th>
                                        {{ __('words.phone') }}
                                    </th>
                                    <th>
                                        {{ __('words.total_earnings') }}
                                    </th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($retailers as $retailer)
                                    <tr>
                                        <td>
                                            <x-qr.direct :size="100" :url="route('shop.register', ['refferal' => $retailer->user_id])" :disabled="true" />
                                        </td>
                                        <td>
                                            {{ $retailer->user->fullName }}
                                        </td>
                                        <td>
                                            {{ $retailer->user->email }}
                                        </td>
                                        <td>
                                            {{ $retailer->user->phone }}

                                        </td>
                                        <td>
                                            {{ $retailer->user->totalEarning() }}
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
</x-dashboard.retailer>
