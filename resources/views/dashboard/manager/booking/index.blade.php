<x-dashboard.manager>
    <h3><span class="text-primary opacity-25">{!! __('words.manager_bokking_sec_title') !!}</span> {{ __('words.bookings') }}</h3>
    <div class="container">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">


                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <form action="{{ url()->current() }}">

                                        <td colspan="6">
                                            <div class="form-group d-flex">
                                                <select name="status" id="filter" class="form-control">
                                                    <option value=""
                                                        @if (request()->status == '') selected @endif>All
                                                    </option>
                                                    <option value="1"
                                                        @if (request()->status == '1') selected @endif>Completed
                                                    </option>
                                                    <option value="0"
                                                        @if (request()->status == '0') selected @endif>Pending
                                                    </option>
                                                    <option value="2"
                                                        @if (request()->status == '2') selected @endif>Expaired
                                                    </option>
                                                </select>
                                            </div>

                                        </td>
                                        <td>
                                            <button class="btn btn-primary">
                                                {{ __('words.filter_btn') }}
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                                <tr>
                                    <th colspan="6">

                                        <select name="show_up_bulk" id="showUpBulk" class="form-control">
                                            <option value="1">
                                                {{ __('words.show_up') }}</option>
                                            <option value="0">
                                                {{ __('words.donot_show_up') }}</option>
                                        </select>

                                    </th>
                                    <th>
                                        <button class="btn btn-primary ml-2" id="submitButton" type="submit">Bulk
                                            Update</button>

                                    </th>
                                </tr>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>{{ __('words.customer') }}</th>
                                    <th>{{ __('words.service') }}</th>
                                    <th colspan="2">{{ __('words.appointment') }}</th>
                                    <th>{{ __('words.dashboard_status') }}</th>
                                    <th>{{ __('words.orders_invoice') }}</th>
                                </tr>

                            </thead>
                            <tbody>
                                @if ($bookings->count() > 0)
                                    @foreach ($bookings as $booking)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="bookings[]" value="{{ $booking->id }}">
                                            </td>
                                            <td>
                                                {{ $booking->customer->full_name }}
                                                <br>
                                                Phone : {{ $booking->customer->phone }}
                                            </td>

                                            <td>
                                                {{ $booking->service->name }}
                                            </td>

                                            <td colspan="2">
                                                {{ $booking->start_at->format('H:i A') }} -
                                                {{ $booking->end_at->format(' H:i A') }} <br>
                                                {{ $booking->end_at->format('d M,Y') }}
                                            </td>

                                            <td>
                                                {{ $booking->status }}
                                            </td>
                                            <td class="d-flex gap-2 flex-wrap">

                                                @if ($booking->status == 'Pending')
                                                    <a href="{{ route('manager.booking.status.completed', $booking) }}"
                                                        class="btn btn-success btn-sm mr-2" title="Completed">
                                                        <i class="fa fa-check"></i>
                                                    </a>
                                                    <a href="{{ route('manager.booking.status.cancel', [$booking, 'charge' => true]) }}"
                                                        class="btn btn-warning btn-sm mr-2"
                                                        title="{{ __('words.cancel') }}">
                                                        <i class="fa fa-times"></i>
                                                    </a>
                                                    @if ($booking->service_type == 1)
                                                        <a href="{{ route('manager.booking.status.cancel', [$booking, 'charge' => false]) }}"
                                                            class="btn btn-danger btn-sm mr-2"
                                                            title="{{ __('words.cancel_without_charge') }}">
                                                            <i class="fa fa-times"></i>
                                                            {{ __('words.cancel_without_charge') }}
                                                        </a>
                                                    @endif
                                                @endif
                                                <button type="button" class="ml-2 btn btn-primary"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                    data-note="{{ $booking->note }}"
                                                    data-form="{{ route('manager.booking.note', $booking) }}">
                                                    <i class="fa fa-envelope"></i>
                                                </button>

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
                                                        <button class="btn btn-primary ml-2"
                                                            type="submit">Update</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                        @if (json_decode($booking->log))
                                            <tr>
                                            </tr>
                                            <tr>
                                                <th colspan="6">
                                                    {{ __('words.btn_re_schedule') }}
                                                </th>
                                            </tr>
                                            @foreach (json_decode($booking->log) as $log)
                                                <tr>
                                                    <td colspan="1">
                                                        <h5>{{ $loop->iteration }}</h5>
                                                    </td>
                                                    <td colspan="3">

                                                        <table class="table">
                                                            <tr>
                                                                <th>
                                                                    {{ __('words.from') }}
                                                                </th>
                                                                <td>
                                                                    {{ Carbon\Carbon::parse($log->from->start_at)->format('H:i A') }}
                                                                    -
                                                                    {{ Carbon\Carbon::parse($log->from->end_at)->format('H:i A') }}
                                                                    <br>
                                                                    {{ Carbon\Carbon::parse($log->from->start_at)->format('d M,Y') }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td colspan="2">
                                                        <table class="table">
                                                            <tr>
                                                                <th>
                                                                    {{ __('words.to') }}
                                                                </th>
                                                                <td>
                                                                    {{ Carbon\Carbon::parse($log->to->start_at)->format('H:i A') }}
                                                                    -
                                                                    {{ Carbon\Carbon::parse($log->to->end_at)->format('H:i A') }}
                                                                    <br>
                                                                    {{ Carbon\Carbon::parse($log->to->start_at)->format('d M,Y') }}
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>


                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                    <tr>
                                        <td colspan="5">
                                            {{ $bookings->links() }}
                                        </td>
                                    </tr>
                                @else
                                    <td colspan="6">
                                        <h1 class="text-center">{{ __('words.manager_product_not_msg') }}</h1>
                                    </td>
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>


    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('words.add_a_note') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="note" method="POST">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}" autocomplete="on">

                        <div class="form-group">
                            <label for="message-text" class="col-form-label">{{ __('words.note_label') }}:</label>
                            <textarea name="note" class="form-control" id="message-text"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('words.close') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('words.save') }}</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    @push('scripts')
        <script>
            $('#exampleModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget) // Button that triggered the modal


                var modal = $(this)

                modal.find('#note').attr('action', button.data('form'))
                modal.find('#message-text').val(button.data('note'));
            })
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const submitButton = document.getElementById('submitButton');
                submitButton.addEventListener('click', () => {
                    const checkboxes = document.querySelectorAll('input[name="bookings[]"]:checked');
                    const selectedOption = document.getElementById('showUpBulk');

                    const formData = new FormData();
                    checkboxes.forEach(checkbox => {
                        formData.append('bookings[]', checkbox.value);
                    });
                    formData.append('show_up_bulk', selectedOption.value);

                    const url =
                        "{{ route('manager.booking.bulk') }}"; // Replace with the actual route

                    fetch(url, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Handle the response from the server
                            console.log(data);
                            window.location.reload(true);
                            // You can update the UI or take any action based on the response
                        })
                        .catch(error => {
                            // Handle errors that occur during the request
                            console.error('Error:', error);
                        });
                });
            });
        </script>
    @endpush
</x-dashboard.manager>
