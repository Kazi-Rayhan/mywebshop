<x-dashboard.user>
    <div class="container my-3">
        <h3>{{ __('words.personal_trainer_header') }}</h3>

        <div class="">

            <div class="card-person">
                <div class="card-thumbnail text-center">
                    <img src="{{ Iziibuy::image($credit->trainer->avatar) }}"
                        style="height:300px;width:300px;object-fit:cover" class="avatar" alt="">

                </div>
                <div class="card-details">
                    <h1 class="text-center mt-2">
                        {{ $credit->trainer->fullName }}
                    </h1>

                    <h4 class="text-center my-3">
                        <i class="fa fa-clock"></i> {{ round($credit->credits / $shop->defaultoption->minutes) }}
                        {{ __('words.sessions') }}
                    </h4>

                </div>
                <div class="card-button text-center">
                    <a href="{{ $credit->trainer->bookingUrl() }}" class="btn btn-dark mt-3">
                        {{ __('words.book') }}
                    </a>
                    <a href="{{ route('trainer.index', [request('user_name'), $credit->trainer]) }}"
                        class="btn btn-dark mt-3">
                        {{ __('words.trainer_update') }}
                    </a>
                    @if ($credit->subscribed())
                        <a href="{{ route('user.renew', [request('user_name'), $credit]) }}"
                            class="btn btn-danger mt-3">
                            {{ __('words.deactive_renew') }}
                        </a>
                    @else
                        <a href="{{ route('user.renew', [request('user_name'), $credit]) }}"
                            class="btn btn-success mt-3">
                            {{ __('words.active_renew') }}
                        </a>
                    @endif
                    <a href="{{ route('user.chat', ['user_name' => request('user_name'), 'user' => $credit->trainer]) }}"
                        class="btn btn-primary mt-3">Send message</a>

                </div>
                <hr>
            </div>

        </div>

    </div>

</x-dashboard.user>
