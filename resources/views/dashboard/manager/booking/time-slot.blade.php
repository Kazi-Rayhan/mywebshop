<x-dashboard.manager>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('simple-calender/simple-calendar.css') }}">
        <link href="{{ asset('css/chat.css') }}" rel='stylesheet' />
        <style>
            .event-container {
                display: none !important
            }

            .selected_day {
                border: 1px solid red !important;
                border-radius: 50%;
            }

            .calendar td {
                font-weight: normal;
                padding: .2em 0.1em;
            }

            .calendar header .month .year {
                display: inline;
                font-size: 17px
            }

            .calendar header .month {
                font-size: 17px
            }

            .calendar thead {
                font-size: 13px;
                text-transform: uppercase
            }

            .calendar .day.today {
                background: #386bc0
            }

            #events {
                max-height: 450px;
                overflow-y: auto
            }

            #events::-webkit-scrollbar {
                width: 5px;
                background: #386bc0
            }

            .wrong-month {
                display: none !important
            }

            .old_day {
                color: #aa9797;
                cursor: default !important;
            }
        </style>
    @endpush
    @php
        $wallet = (new App\Services\CreditWallet($user, $manager))->get();
    @endphp
    <div class="container-fluid mt-5">
        @if (request('reschedule'))
            <div class="row my-5">
                <div class="col-md-12">
                    <h3 class="text-center"> {{ __('words.reschedule_text') }}</h3>
                </div>
            </div>
        @endif
        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('manager.confirm_booking', [$user, $service]) }}" method="get">

                            <input type="hidden" name="type" value="subscription">
                            <div class="row row-cols-2">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="from">{!! __('words.from') !!}</label>
                                        <input type="datetime-local" class="form-control"
                                            @if (request()->filled('start_at'))  @endif name="start_at">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="miniutes">{!! __('words.miniutes') !!}</label>
                                        <input type="number" class="form-control"
                                            @if (request()->filled('miniutes'))  @endif name="miniutes" min="0"
                                            max="{{ $wallet->subscription_credits }}">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                {!! __('words.book') !!}
                            </button>


                        </form>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-start flex-wrap gap-2 mb-2 ">
                    @foreach ($trainer_services as $s)
                        <a id="details" title="{{ $s->getTranslatedAttribute('details', app()->getLocale()) }} "
                            href=" @if ($option->id == $s->id) # @else {{ route('manager.booking.book', [$user, $s]) }} @endif"
                            class="border border-primary d-block text-center px-3 py-2 font-weight-bold @if ($option->id == $s->id) bg-primary text-light @else text-primary @endif rounded">
                            {{ $s->getTranslatedAttribute('title', app()->getLocale()) }}
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-md-6 col-sm-12 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div id="calander">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-1 col-sm-12 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <p class="ml-3 mb-4 today_date">{{ now()->format('D, d F') }}</p>
                        <div id="events"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 p-1 col-sm-12 col-lg-4">
                <div class="card chat-app shadow">
                    <div class="card-header">
                        <h3 class="mb-4">{{ __('words.messages') }}</h3>
                    </div>
                    <div class="chat" style="margin-left: 0">
                        <div class="chat-header clearfix">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="chat-about">
                                        <h6 class="m-b-0">{{ $user->fullName }}</h6>
                                        <img src="{{ Iziibuy::image($user->avatar) }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chat-history" style="height: 350px;overflow-y:scroll">
                            <ul class="m-b-0">
                                @foreach ($messages as $message)
                                    <li class="clearfix">
                                        <div
                                            class="message-data {{ $message->message_sender->id == $user->id ? '' : 'text-right' }}">


                                        </div>
                                        <div title="{{ $message->created_at->diffForHumans() }}"
                                            class="message {{ $message->message_sender->id == $user->id ? 'my-message' : 'other-message float-right' }}">
                                            {{ $message->message }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="chat-message clearfix">
                            <form action="{{ route('send.message', ['user' => $manager]) }}" method="post">
                                @csrf
                                <div class="input-group mb-0">
                                    <input type="text" name="message" required
                                        class="form-control @error('message') is-invalid @enderror"
                                        placeholder="Enter text here...">
                                    <div class="input-group-prepend" style="cursor: pointer">
                                        <button class="input-group-text" style="font-size: 1.5rem;margin-left: 5px"><i
                                                class="far fa-paper-plane"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-8 mt-3">
                <div class="card shadow">
                    <div class="card-body table-responsive">
                        <h3 class="mb-2">
                            {{ __('words.booking') }}
                        </h3>
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th>{{ __('words.customer') }}</th>
                                    <th>{{ __('words.appointment') }}</th>
                                    <th>{{ __('words.dashboard_status') }}</th>
                                    <th>{{ __('words.action') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if ($bookings->count() > 0)
                                    @foreach ($bookings as $booking)
                                        <tr>
                                            <td>
                                                {{ $booking->customer->full_name }}
                                                <br>
                                                Phone : {{ $booking->customer->phone }}
                                            </td>

                                            <td>
                                                {{ $booking->start_at->format('H:i A') }} -
                                                {{ $booking->end_at->format(' H:i A') }} <br>
                                                {{ $booking->end_at->format('d M, Y') }}
                                            </td>

                                            <td>
                                                {{ $booking->status }}
                                            </td>
                                            <td>
                                                <?php
                                                $endAt = Carbon\Carbon::parse($booking->end_at);
                                                ?>
                                                @if ($endAt->isPast())
                                                    <form action="{{ route('manager.booking.index') }}"
                                                        class="mt-3 form-inline">
                                                        <input type="hidden" name="booking_id"
                                                            value="{{ $booking->id }}">
                                                        <select name="show_up" id="" class="form-control">
                                                            <option value="1"
                                                                {{ $booking->show_up == 1 ? 'selected' : '' }}>
                                                                {{ __('words.show_up') }}</option>
                                                            <option value="0"
                                                                {{ $booking->show_up == 0 ? 'selected' : '' }}>
                                                                {{ __('words.donot_show_up') }}</option>
                                                        </select>
                                                        <button class="btn btn-primary" type="submit">Save</button>
                                                    </form>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach
                                @else
                                    <td colspan="6">
                                        <h1 class="text-center">
                                            {{ __('words.dashboard_no_order_msg') }}
                                        </h1>
                                    </td>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card shadow">
                    <div class="card-body">
                        <x-reports.index :orders="$orders" />
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mt-3">
                <div class="card">
                    <div class="card-header">
                        {{ __('words.pt_instruction') }}
                    </div>
                    <div class="card-body">
                        <div class="position-relative">
                            <div>

                                {{ $user->fullName }}
                                <br>
                                {{ $user->email }}
                            </div>
                            <i class="position-absolute fas fa-edit" style="top:0;right:0;" type="button"
                                data-bs-toggle="modal" data-bs-target="#exampleModalCenter"></i>
                        </div>
                        <hr>
                        {{ $manager->fullName }} <br>
                        <i class="fa fa-clock"></i>
                        {{ round($user->getCredits($shop->id, $manager->id) / $option->minutes) }}
                        {{ __('words.sessions') }}
                        <ul>

                            <li>
                                <i class="fa fa-clock"></i> {{ round($wallet->session_credits / $option->minutes) }}
                                {{ __('words.session_sessions') }}
                            </li>
                            <li>
                                <i class="fa fa-clock"></i>
                                {{ round($wallet->subscription_credits / $option->minutes) }}
                                {{ __('words.subscription_sessions') }}
                            </li>
                            <li>
                                <i class="fa fa-clock"></i>
                                {{ round($wallet->admin_credits + $wallet->manager_credits / $option->minutes) }}
                                {{ __('words.free_sessions') }}
                            </li>
                        </ul>
                        <h4>{{ __('words.auto_renew') }}: @if (auth()->user()->getCredit($shop->id, $manager->id)
                                ?->subscribed())
                                <a href="#">
                                    <span class="text-success">{{ __('words.on') }}</span>
                                </a>
                            @else
                                <a href="#">
                                    <span class="text-danger">{{ __('words.off') }}</span>
                                </a>
                            @endif
                        </h4>
                        <p>{{ __('words.will_automatic_renew_your_session') }}</p>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ __('words.clients') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('manager.booking.client.update', $user) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('put')
                        @include('dashboard.manager.client.form')
                    </form>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('simple-calender/jquery.simple-calendar.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @if (session()->has('success-booking'))
            <script>
                Swal.fire({
                    title: "{{ __('words.booking_success_title') }}",
                    text: "{{ __('words.booking_alert_text') }}",
                    icon: 'success',
                })
            </script>
        @endif

        <script>
            const months = [
                "January", "February",
                "March", "April", "May",
                "June", "July", "August",
                "September", "October",
                "November", "December"
            ];
            $("#calander").simpleCalendar({
                onDateSelect: function(date, events) {
                    let mont_name = months[date.getMonth()]
                    let day = date.getDate()
                    let daye_name = date.toLocaleDateString('en-US', {
                        weekday: 'long'
                    })
                    let new_date = date.toLocaleDateString("en-US");
                    $('.today_date').text(daye_name + ', ' + day + ' ' + mont_name)
                    localStorage.setItem('lastVisitedMonth', date.toISOString());
                    
                    fetchEvent(new_date)
                }
            });
        </script>
        <script>
            $('.old_day').prop('disabled', true);
        </script>

        <script>
            let service = @json($service);
            let manager = @json($manager);
            let user = @json($user);
            let shop = "{{ request('user_name') }}";
            let reschedule = "{{ request('reschedule') }}";
            let baseUrl = `${window.location.origin}`;
            let fetchEvent = (date) => {
                $.ajax({
                    headers: {
                        Accept: "application/json",
                    },
                    url: `${window.location.href}?date=${date}`,
                }).done(({
                    events
                }) => {

                    let events_html = '';
                    if (events.length > 0) {
                        events.map((event) => {
                            events_html += `
                    <div class='col-12 mb-3'>
                        <a type="button" onclick="confirm(this)" data-slot="${event.slot}"  data-date="${date}" class='border border-primary d-block text-center p-2 font-weight-bold text-primary rounded'>
                            ${event.name}
                        </a>
                    </div>`;
                            //console.log()
                        })
                    } else {
                        events_html =
                            `<div class="border text-center p-2 rounded m-2">No Events Found.Please select a new date</div>`;
                    }

                    $('#events').html(events_html);
                });
            }
            fetchEvent("{{ now()->format('m/d/Y') }}");


            const confirm = (data) => {
                baseUrl
                Swal.fire({
                    title: "",
                    text: "{{ __('words.booking_alert_title') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{ __('words.booking_alert_confirm') }}",
                    cancelButtonText: "{{ __('words.booking_alert_cancel') }}"
                }).then((result) => {

                    if (result.isConfirmed) {
                        const url =
                            `${baseUrl}/my-manager-dashboard/${user.id}/${service.id}/booking-confirm`;
                        window.location.href =
                            `${url}?date=${data.dataset.date}&time=${data.dataset.slot}&reschedule=${reschedule}`;


                    }
                })
            }
        </script>
    @endpush
</x-dashboard.manager>
