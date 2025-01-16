<?php
use App\Models\Shop;
$shop = Shop::where('user_name', request('user_name'))->firstOrFail();
session()->put('shop_id', $shop->id);
?>
<x-shop-front-end>

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
        <div class="row">
            <div class="col-md-6 col-sm-12 col-lg-6">
                <div class="card h-100">
                    <div class="card-body">
                        <div id="calander">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 p-1 col-sm-12 col-lg-6">
                <div class="card h-100">
                    <div class="card-body">
                        <p class="ml-3 mb-4 today_date">{{ now()->format('D, d F') }}</p>
                        <div id="events"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.4.1/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.2/evo-calendar/js/evo-calendar.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('js/custom/booking.js') }}"></script>
        <script></script>
    @endpush
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
            $('.old_day').prop('disabled', true);
        </script>
        <script>
            let shop = "{{ request('user_name') }}";
            let reschedule = "{{ request('reschedule') }}";
            let baseUrl = `${window.location.origin}`;
            const service = @json($service);
            const manager = @json($manager);
            const fetchEvent = (date) => {
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
                    title: "{{ __('words.booking_alert_title') }}",
                    text: "{{ __('words.booking_alert_sub_title') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "{{ __('words.booking_alert_confirm') }}",
                    cancelButtonText: "{{ __('words.booking_alert_cancel') }}"
                }).then((result) => {

                    if (result.isConfirmed) {
                        const url =
                            `${baseUrl}/shop/${shop}/confirm-booking/${service.slug}/${manager.id}`;
                        console.log(url)
                        window.location.href =
                            `${url}?date=${data.dataset.date}&time=${data.dataset.slot}&reschedule=${reschedule}`;
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
                    $('.today_date').text(daye_name + ', ' + day + ' ' + mont_name);
                    fetchEvent(new_date)
                }
            });
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
