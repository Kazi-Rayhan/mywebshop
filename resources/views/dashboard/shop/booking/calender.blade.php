<x-dashboard.shop>
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
                                        <td colspan="5">
                                            <div class="form-group">
                                                <label for="filter">{{ __('words.filter_btn') }}</label>
                                                <select name="status" id="filter" class="form-control">
                                                    <option value=""
                                                        @if (request()->status == '') selected @endif>All</option>
                                                    <option value="1"
                                                        @if (request()->status == '1') selected @endif>Completed</option>
                                                    <option value="0"
                                                        @if (request()->status == '0') selected @endif>Pending</option>
                                                    <option value="2"
                                                        @if (request()->status == '2') selected @endif>Expaired</option>
                                                </select>
                                            </div>
                                            <button class="btn btn-primary">
                                                {{ __('words.filter_btn') }}
                                            </button>
                                        </td>
                                    </form>
                                </tr>
                                <tr>
                                    <th>{{ __('words.customer') }}</th>

                                    <th>{{ __('words.service') }}</th>
                                    <th>{{ __('words.appointment') }}</th>
                                    <th>{{ __('words.dashboard_status') }}</th>
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
                                                {{ $booking->service->name }}
                                            </td>

                                            <td>
                                                {{ $booking->start_at->format('H:i A') }} -
                                                {{ $booking->end_at->format(' H:i A') }} <br>
                                                {{ $booking->end_at->format('d M,Y') }}
                                            </td>

                                            <td>
                                                {{ $booking->status }}
                                            </td>
                                        </tr>
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="note" method="POST">

                        <input  type="hidden" name="_token" value="{{ csrf_token() }}" autocomplete="on">

                        <div class="form-group">
                            <label for="message-text" class="col-form-label">{{ __('words.note_label') }}:</label>
                            <textarea name="note" class="form-control" id="message-text"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{__('words.close')}}</button>
                    <button type="submit" class="btn btn-primary">{{__('words.save')}}</button>
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
    @endpush
</x-dashboard.shop>
