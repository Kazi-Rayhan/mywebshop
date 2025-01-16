@extends('voyager::master')
@section('content')
    <div class="container">
        <h3 class="hidden-print"><span class="text-primary opacity-25 ">Retailer</span> Reports</h3>
        <div class="row mt-3 hidden-print">
            <div class="col ">
                <div class="card">
                    <div class="card-body">
                        <form action="" class="hidden-print" method="get">


                            <div class="row  row-cols-2">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="from">From</label>
                                        <input type="date" class="form-control"
                                            @if (request()->filled('from')) value="{{ Carbon\Carbon::parse(request()->from)->format('Y-m-d') }}" @endif
                                            name="from">
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="to">To</label>
                                        <input type="date" class="form-control"
                                            @if (request()->filled('to')) value="{{ Carbon\Carbon::parse(request()->to)->format('Y-m-d') }}" @endif
                                            name="to">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Filter
                            </button>
                            <a href="" class="btn btn-primary">Reset</a>

                        </form>
                    </div>

                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td colspan="2">
                                    <button class="btn btn-primary hidden-print" onclick="window.print()"><i
                                            class="fa fa-print" aria-hidden="true"></i> Print</button>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    #
                                </th>
                                <th>
                                    Date & Time
                                </th>
                                <th>
                                    Amount
                                </th>
                                <th>
                                    Shop
                                </th>
                                <th>
                                    Method
                                </th>

                                <th>
                                    Details
                                </th>



                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sells as $sell)
                                <tr>
                                    <td>
                                        {{ $sell->id }}
                                    </td>
                                    <td>
                                        {{ $sell->created_at->format('d M, Y ( h:i A )') }}
                                    </td>
                                    <td>
                                        {{ Iziibuy::round_num($sell->amount) }} NOK
                                    </td>
                                    <td>
                                        @if ($sell->shop)
                                            <a
                                                href="{{ route('voyager.shops.show', $sell->shop_id) }}">{{ $sell->shop->user_name }}</a>
                                        @else
                                            <span>N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $sell->method }}
                                    </td>
                                    <td>
                                        @if ($sell->details)
                                            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal"
                                                data-target="#flipFlop" onclick="setdetails(this)"
                                                data-details="{{ $sell->details }}">
                                                See Details
                                            </button>
                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3">
                                    <h4>
                                        Total :
                                    </h4>
                                </td>
                                <td>
                                    <h4>
                                        {{ Iziibuy::round_num($sells->sum('amount')) }} NOK
                                    </h4>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="flipFlop" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="modalLabel">Earning Details</h4>
                </div>
                <div id="charge-details" class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>

    @section('javascript')
        <script>
            const titleCase = (s) =>
                s.replace(/^_*(.)|_+(.)/g, (s, c, d) => c ? c.toUpperCase() : ' ' + d.toUpperCase())

            function objToList(obj) {
                let ul = document.createElement('ul');

                for (const key in obj) {
                    let li = document.createElement('li');
                    if (typeof(obj[key]) == 'object') {
                        let p = document.createElement('p');
                        p.innerText = titleCase(key) + ' :';
                        li.appendChild(p);
                        li.appendChild(objToList(obj[key]));
                    } else {
                        li.innerText = `${titleCase(key)} : ${obj[key]}`;
                    }
                    ul.appendChild(li);
                }
                return ul
            }

            function setdetails(e) {

                document.getElementById('charge-details').innerHTML = '';
                if (e.dataset.details) {
                    let details = JSON.parse(e.dataset.details);
                    document.getElementById('charge-details').appendChild(objToList(details));

                } else {
                    document.getElementById('charge-details').innerText = 'Nothing found';

                }


            }
        </script>
    @endsection
@endsection
