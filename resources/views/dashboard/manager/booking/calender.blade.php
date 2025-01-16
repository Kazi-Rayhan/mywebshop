<x-dashboard.manager>
<h3 class="d-print-none">{!! __('words.calender_sec_title') !!}</h3>


@push('styles')
    <link href="{{ asset('css/chat.css') }}" rel='stylesheet' />

    <link rel="stylesheet" href="{{ asset('simple-calender/simple-calendar.css') }}">
@endpush
<div class="row">
    <div class="col-12 col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <div id="calander">

                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card" style="height:500px;overflow:scroll">
            <div class="card-body p-1">
                <p class="ml-3 mb-4 today_date">{{ now()->format('D, d F') }}</p>
                <div id="events"></div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        {{-- <h3><span class="text-primary opacity-25 "></span> {{ __('words.chats') }}</h3> --}}
        <div class="card  chat-app">
            <div class="card-body p-2">
                <div  class="people-list p-0 w-100" style="position: relative;height:450px;overflow-y:auto">
                    <ul class="list-unstyled chat-list mt-2 mb-0">
                        @foreach ($clients as $client)
                        @php
                            $unseen = $client
                                ->sentMessages(auth()->user())
                                ->where('seen', 0)
                                ->count();
                            $latest_message = $client
                                ->sentMessages(auth()->user())
                                ->latest()
                                ->first();
                        @endphp
                            <li class="clearfix">
                                <a href="{{ route('manager.booking.book', [$client, auth()->user()->getShop()->defaultoption]) }}">
                                    <img src="{{ Iziibuy::image($client->avatar) }}" alt="avatar">
                                    <div class="about">
                                        <div class="name">{{ $client->name }}</div>
                                        <span class="small font-weight-bold">{{$latest_message?->message}}</span>
                                    </div>
                                    @if ($unseen)
                                        <span class="badge badge-primary ml-2">{{ $unseen }} </span>
                                    @endif
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>


    @push('scripts')
        <script src="{{ asset('simple-calender/jquery.simple-calendar.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
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
                    fetchBooking(new_date)
                }
            });
            const url = "{{ route('manager.booking.getEvents') }}";
            const fetchBooking = (date) => {
                $.ajax({
                    headers: {
                        Accept: "application/json",
                    },
                    url: `${url}?date=${date}`,
                }).done(({
                    data
                }) => {
                    let events_html = '';
                    if (data.length > 0) {
                        data.map((event) => {
                            console.log(event)
                            events_html += `
                <div class='col-12 mb-1 pl-1 pr-1'>
                    <div class="card mb-2 border border-success">
                        <div class="card-body p-2">
                           <h5>
                           ${event.title}
                           </h5>
                          <h6>${event.start} - ${event.end}</h6>
                        </div>
                    </div>
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
            fetchBooking("{{ now()->format('m/d/Y') }}");
        </script>
    @endpush
</x-dashboard.manager>
