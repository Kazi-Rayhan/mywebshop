<?php
$shop = App\Models\Shop::where('user_name', request('user_name'))->first();
?>

<x-shop-front-end>
    @php
        $wallet = (new App\Services\CreditWallet(auth()->user(), $manager))->get();
    @endphp
    @push('style')
        <link rel="stylesheet" href="{{ asset('simple-calender/simple-calendar.css') }}">
        <link href="{{ asset('css/chat.css') }}" rel='stylesheet' />
        <link rel="stylesheet" href="{{ asset('css/custom/checkout.css') }}">
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

            .checkout-charge ul {
                width: 100%;
            }

            .checkout-part {
                padding: 0;
            }
        </style>
    @endpush

    <div class="container mt-5">

        <div class="card shadow">
            <div class="card-body">
                <h2 class="text-center">
                    {{ __('words.dashboard_booking_user') }}
                </h2>
                <br>
                <p>
                    {{ __('words.dashboard_booking_details') }} <br>
                    {{ __('words.dashboard_booking_details_able') }}
                </p>
                <ul>
                    <li>{{ __('words.dashboard_booking_details_book') }}</li>
                    <li>{{ __('words.dashboard_booking_details_chat') }}</li>
                    <li>{{ __('words.dashboard_booking_details_manage') }}</li>
                </ul>


            </div>
        </div>
        @if (request('reschedule'))
            <div class="row my-5">
                <div class="col-md-12">
                    <h3 class="text-center"> {{ __('words.reschedule_text') }}</h3>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-start flex-wrap gap-2 mb-2 ">
                    @foreach ($trainer_services as $s)
                        <a id="details" title="{{ $s->getTranslatedAttribute('details', app()->getLocale()) }} "
                            href=" @if ($option->id == $s->id) # @else {{ route('trainer_services.schedule', ['user_name' => request('user_name'), 'user' => $manager, 'option' => $s]) }} @endif"
                            class="border border-primary d-block text-center mx-2 px-3 py-2 font-weight-bold @if ($option->id == $s->id) bg-primary text-light @else text-primary @endif rounded">
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
                                <div class="col-lg-12">
                                    <div class="chat-about w-100 d-flex  align-items-center ">
                                        <img class="mr-2" src="{{ Iziibuy::image($manager->avatar) }}"
                                            alt="">
                                        <h6 class="">{{ $manager->fullName }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="chat-history" style="height: 350px;overflow-y:scroll">
                            <ul class="m-b-0">
                                @foreach ($messages as $message)
                                    <li class="clearfix">
                                        <div
                                            class="message-data {{ $message->message_sender->id == auth()->id() ? '' : 'text-right' }}">


                                        </div>
                                        <div title="{{ $message->created_at->diffForHumans() }}"
                                            class="message {{ $message->message_sender->id == auth()->id() ? 'my-message' : 'other-message float-right' }}">
                                            {{ $message->message }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="chat-message clea   rfix">
                            <form action="{{ route('send.message', ['user' => $manager]) }}" method="post">
                                @csrf
                                <div class="input-group mb-0">
                                    <input type="text" name="message" required
                                        class="form-control @error('message') is-invalid @enderror"
                                        placeholder="Enter text here...">
                                    <div class="input-group-prepend" style="cursor: pointer">
                                        <button class="input-group-text"><i class="far fa-paper-plane"></i></button>
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
                                    <th>#</th>
                                    <th>{{ __('words.service') }}</th>
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
                                                {{ $booking->id }}
                                            </td>
                                            <td>
                                                {{ $booking->service->name }}
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
                                                <div class="d-flex flex-wrap justify-content-between">
                                                    <a class="text-primary" title="{{ __('words.view_btn') }}"
                                                        href="javascript:void(0)" data-toggle="modal"
                                                        data-target="#booking-details"
                                                        data-title="{{ $booking->service->name }}"
                                                        data-manager="{{ $booking->manager->full_name }}"
                                                        data-price="{{ $booking->service->priceFormated($booking->manager) }}"
                                                        data-appointment="{{ $booking->start_at->format('M d, Y') }} at {{ $booking->start_at->format('h:ia') }}-{{ $booking->end_at->format('h:ia') }}"
                                                        data-status="{{ $booking->status }}"
                                                        data-payment="{{ $booking->payment_status }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    @if (Carbon\Carbon::parse(now()) < $booking->start_at->subDay(1)->endOfDay())
                                                        @if ($booking->status == 'Pending')
                                                            <a class="text-danger" title="{{ __('words.btn_cancel') }}"
                                                                href="javascript:void(0)" onclick="cancel(this)"
                                                                data-href="{{ route('cancel.booking', [request()->user_name, $booking]) }}">
                                                                <i class="fa fa-times"></i>
                                                            </a>
                                                            <a class="text-warning"
                                                                title=" {{ __('words.btn_re_schedule') }}"
                                                                href="{{ route('trainer_services.schedule', [request()->user_name, $manager, $service, 'reschedule' => $booking]) }}">
                                                                <i class="fa fa-calendar"></i>
                                                            </a>
                                                        @endif
                                                    @endif
                                                </div>


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
            </div>
            <div class="col-lg-4 mt-3">
                <div class="card">
                    <div class="card-header">
                        {{ __('words.pt_instruction') }}
                    </div>
                    <div class="card-body">
                        {{ $manager->fullName }} <br>
                        <i class="fa fa-clock"></i>

                        {{ round(auth()->user()->getCredits($shop->id, $manager->id) / $option->minutes) }}
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
                        <a href="{{ route('trainer.index', [request('user_name'), $manager]) }}"
                            class="btn btn-dark mt-3">
                            {{ __('words.trainer_update') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    <div class="modal fade" id="booking-details" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookingTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <section class="checkout-part">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="checkout-charge">
                                        <ul>
                                            <li>
                                                <span>{{ __('words.service') }}
                                                    {{ __('words.dashboard_category_index_name') }}</span>
                                                <span id="serviceName"></span>
                                            </li>
                                            <li>
                                                <span>{{ __('words.dashboard_managers') }}</span>
                                                <span id="managerName"></span>
                                            </li>
                                            <li>
                                                <span>{{ __('words.cart_table_price') }}</span>
                                                <span id="servicePrice"></span>
                                            </li>
                                            <li>
                                                <span>{{ __('words.appointment') }} {{ __('words.charge_at') }}</span>
                                                <span id="appointment">


                                                </span>
                                            </li>
                                            <li>
                                                <span>{{ __('words.dashboard_status') }}</span>
                                                <span id="serviceStatus">


                                                </span>
                                            </li>
                                            <li>
                                                <span>{{ __('words.payment_status') }}</span>
                                                <span id="paymentStatus">


                                                </span>
                                            </li>



                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>



            </div>
        </div>
    </div>


    @push('js')

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
            const cancel = (data) => {
                baseUrl
                Swal.fire({
                    title: "{{ __('words.booking_cancel_title') }}",
                    text: "{{ __('words.booking_cancel_text') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{ __('words.yes') }}",
                    cancelButtonText: "{{ __('words.no') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = data.dataset.href
                    }
                })
            }
        </script>
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
            let shop = "{{ request('user_name') }}";
            let reschedule = "{{ request('reschedule') }}";
            let baseUrl = `${window.location.origin}`;
            let fetchEvent = (date) => {
                var currentUrl = window.location.href;
                var url = new URL(currentUrl);
                url.searchParams.set("date", date);
                $.ajax({
                    headers: {
                        Accept: "application/json",
                    },
                    url: url,
                }).done(({
                    events
                }) => {

                    let events_html = '';
                    if (events.length > 0) {
                        events.map((event) => {
                            events_html += `
                    <div class='col-12 mb-3'>
                        <a type="button" onClick="confirm(this)" data-slot="${event.slot}"  data-date="${date}" class='border border-primary d-block text-center p-2 font-weight-bold text-primary rounded'>
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
                    title: "{{ $service->getTranslatedAttribute('details', app()->getLocale()) }}",
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
                            `${baseUrl}/shop/${shop}/confirm-booking/trainer/${manager.id}/${service.id}`;
                        window.location.href =
                            `${url}?date=${data.dataset.date}&time=${data.dataset.slot}&reschedule=${reschedule}`;
                    }
                })
            }
        </script>
        <script>
            $('#exampleModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget) // Button that triggered the modal


                var modal = $(this)


                modal.find('#message-text').text(button.data('note'));
            })
        </script>
        <script>
            $('#booking-details').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                var serviceTitle = button.data('title')
                var managerName = button.data('manager')
                var servicePrice = button.data('price')
                var appointment = button.data('appointment')
                var serviceStatus = button.data('status')
                var paymentStatus = button.data('payment')
                var btnUrl = button.data('paymentbtn')
                console.log(btnUrl)
                var modal = $(this)
                modal.find('#bookingTitle').text(serviceTitle)
                modal.find('#serviceName').text(serviceTitle)
                modal.find('#servicePrice').text(servicePrice)
                modal.find('#appointment').text(appointment)
                modal.find('#serviceStatus').text(serviceStatus)
                modal.find('#paymentStatus').text(paymentStatus)

            })
        </script>

    @endpush
</x-shop-front-end>
