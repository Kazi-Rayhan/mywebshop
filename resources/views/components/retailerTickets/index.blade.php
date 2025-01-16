<div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a class="btn btn-success float-right" href="{{ route('retailer.tickets.create') }}"><i class="fas fa-plus"></i> {!! __('words.ticket_new') !!}</a>
                    <h3>{!! __('words.ticket_header') !!} </h3>
                </div>
                <div class="card-body shadow-lg">

                    <table class="table">
                        <thead>

                            <tr>
                                <th>{{ __('words.ticket_id') }}</th>
                                <th>{{ __('words.ticket_subject') }}</th>
                                <th>{{ __('words.ticket_image') }}</th>
                                <th>{{ __('words.ticket_status') }}</th>
                                <th>{{ __('words.ticket_action_massage') }}</th>
                                <th>{{ __('words.ticket_action') }}</th>
                            </tr>
                        </thead>
                        <tbody x-data="orderable" id="container">
                            @foreach ($tickets as $ticket)
                            <tr class="dragable">
                                <td>{{$loop->index+1}}</td>
                                <td>
                                    {{ $ticket->subject }}
                                </td>


                                <td>
                                    <img src="{{ Iziibuy::image($ticket->image) ? Iziibuy::image($ticket->image) : 'https://ciat.cgiar.org/wp-content/uploads/image-not-found.png' }}" height="80px" alt="{{ $ticket->subject }}">
                                </td>
                                <td>
                                    @if($ticket->status==false)
                                    <a class="btn btn-sm btn-warning p-0">Close</a>
                                    @else
                                    <a class="btn btn-sm  btn-dark text-white p-0">Open</a>
                                    @endif
                                </td>
                                <td style="width:20px">
                                    @if($ticket->action==false)
                                    <p class="text-success ">
                                     <!-- Awaiting response from the admin -->
                                     {{ __('words.ticket_action_massage_awaitting_from_admin') }}
                                    </p>
                                    @else
                                    <p class="text-warning">
                                    {{ __('words.ticket_action_massage_awaitting_from_customer') }}
                                    </p>
                                    @endif

                                </td>
                                <td>


                                    <a title="Product List" class="btn btn-info btn-sm" href="{{ route('tickets.show',$ticket) }}"><i class="fa fa-eye"></i></a>

                                    <a class="btn {{ $ticket->status ? 'btn-danger' : 'btn-success' }} py-1" href="{{route('retailer.ticket.close',$ticket)}}">{{ $ticket->status ? 'Close' :'Open' }}</a>

                                </td>
                            </tr>
                            @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
