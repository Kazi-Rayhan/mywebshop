<x-dashboard.manager>
    <h3><span class="text-primary opacity-25 mr-2"><i class="fas fa-users"
                aria-hidden="true"></i></span>{{ __('words.clients') }}</h3>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success float-right" href="{{ route('manager.clients.create') }}"><i
                            class="fas fa-plus"></i>
                        {!! __('words.create_client') !!} </a>
                </div>
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
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="container">
                            @foreach ($users as $user)
                                @php
                                    $credits = $user->getCredits($shop->id, $manager->id);
                                @endphp
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <img src="{{ Iziibuy::image($user->avatar) }}" style="width: 60px">
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
                                    <td class="">
                                        <div class="d-flex flex-wrap gap-2">
                                            {{-- <a href="{{ route('manager.booking.client.edit', $user) }}"
    class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a> --}}
                                       
                                            <a href="{{ route('manager.booking.book', [$user, $shop->defaultoption]) }}"
                                                class="btn btn-sm btn-primary">{{ __('words.book') }}</a>
                                            <a href="{{ route('manager.booking.services', $user) }}"
                                                class="btn  btn-sm btn-primary"><i class="fa fa-cogs"></i></a>
                                            <a data-bs-toggle="modal" data-bs-target="#credit_add_modal"
                                                onclick="changeUserId({{ $user->id }})" href="javascript::void()"
                                                class="btn btn-sm btn-primary"><i class="fa fa-plus"></i>
                                                {{ __('words.add_a_free_session') }}</a>
                                            <x-helpers.delete :url="route('manager.booking.client.delete', $user)" :id="$user->id" />
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="credit_add_modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('manager.booking.client.addSessions') }}">
                    <input type="hidden" name="user_id" id="user_id" value="">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('words.free_credit_title') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="number" class="form-control" placeholder="10" name="session" step="1"
                            required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ __('words.save') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <script>
        function changeUserId(user_id) {
            const hiddenInput = document.getElementById("user_id");
            hiddenInput.value = user_id;
            console.log(user_id)
        }
    </script>
</x-dashboard.manager>
