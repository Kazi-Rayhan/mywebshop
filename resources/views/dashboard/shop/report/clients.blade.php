<x-dashboard.shop>
    @php
        $url = url()->current();
    @endphp
  
    <h3><span class="text-primary opacity-25 mr-2"><i class="fas fa-users"
        aria-hidden="true"></i></span>{{ __('words.clients') }}</h3>

<div class="row">
<div class="col-lg-12">
    <div class="card">
        @if (!str_contains($url, 'my-shop-dashboard'))
        <div class="card-header">
            <a class="btn btn-success float-right" href="{{ route('manager.booking.client.create') }}"><i
                    class="fas fa-plus"></i>
                {!! __('words.create_client') !!} </a>
        </div>
        @endif
        <div class="card-body shadow-lg table-responsive">

            <table class="table">
                <thead>

                    <tr>
                        <th>#</th>
                        <th>{{ __('words.profile_image') }}</th>
                        <th>{{ __('words.checkout_form_first_name_label') }}</th>
                        <th>{{ __('words.checkout_form_lastname') }}</th>
                        <th>{{ __('words.checkout_form_email') }}</th>
                        <th>{{ __('words.invoice_tel') }}</th>
                        <th>{{ __('words.credits') }}</th>
                    </tr>
                </thead>
                <tbody id="container">
                    @foreach ($users as $user)
                        @php
                            $credits = $user->getCredits($shop->id, $user->personal_trainner);
                        @endphp
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>
                            <td>
                                <img src="{{ Voyager::image($user->avatar)}}" style="width: 60px">
                            </td>
                            <td>
                                {{ $user->name }}
                            </td>
                            <td>
                                {{ $user->last_name }}
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>
                                {{ $user->phone }}

                            </td>
                            <td>
                                {{ $credits }}
                            </td>
                            {{-- <td>
                                <a href="{{ route('manager.booking.client.edit', $user) }}"
                                    class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                <x-helpers.delete :url="route('manager.booking.client.delete', $user)" :id="$user->id" />

                                <a href="{{ route('manager.booking.book', [$user, $shop->defaultoption]) }}"
                                    class="btn btn-sm btn-primary">{{ __('words.book') }}</a>
                                <a href="{{route('manager.booking.services',$user)}}" class="btn  btn-sm btn-primary"><i class="fa fa-cogs"></i></a>
                            </td> --}}
                        </tr>
                    @endforeach

                </tbody>

            </table>
            {{ $users->links() }}
        </div>
    </div>
</div>
</div>


</x-dashboard.shop>
