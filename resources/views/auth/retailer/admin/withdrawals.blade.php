@extends('voyager::master')
@section('css')
    <style>
        .widget.widget-tile {
            padding: 24px 20px;
            margin-bottom: 25px;
            display: table;
            table-layout: fixed;
            width: 100%;
        }

        .widget {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 3px;
        }

        .widget.widget-tile .chart {
            width: 85px;
            min-height: 45px;
            padding: 5px 0;
            display: table-cell;
            vertical-align: middle;
            text-align: right;
        }

        .widget.widget-tile .data-info {
            display: table-cell;
            text-align: left;
        }

        .widget.widget-tile .data-info .desc {
            font-size: 1.077rem;
            line-height: 18px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .widget.widget-tile .data-info .value {
            font-size: 1.693rem;
            font-weight: 300;
        }

        .widget.widget-tile .chart .icon {
            font-size: 30px;
        }

        .text-white {
            color: #fff
        }

        .font-bolder {
            font-weight: bolder;
        }
    </style>
@stop
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h3 class="hidden-print"><span class="text-primary opacity-25 ">Retailer</span>
                    Withdrawals </h3>

                <div class="row mt-3 hidden-print">
                    <div class="col ">
                        <div class="card">
                            <div class="card-body">

                                <form action="{{ route('admin.retailer.retailer-withdrawals', ['user' => $user]) }}"
                                    method="get">
                                    <div class="row">
                                        @if (request()->filled('retailer'))
                                            <input type="hidden" name="retailer" value="{{ request()->retailer }}">
                                        @endif
                                        <div class="form-group col-md-6 col-12">
                                            <label for="filter">Filter By</label>
                                            <select name="filter" class="form-control" id="">
                                                <option value="" selected>All</option>
                                                <option value="1" @if ('1' == request()->filter) selected @endif>
                                                    Completed</option>
                                                <option value="0" @if ('0' == request()->filter) selected @endif>
                                                    Pending</option>
                                                <option value="2" @if ('2' == request()->filter) selected @endif>
                                                    Canceled</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3 col-12">
                                            <label for="from">From</label>
                                            <input type="date" class="form-control" value="{{ $form }}"
                                                name="from">
                                        </div>
                                        <div class="form-group  col-md-3 col-12">
                                            <label for="to">To</label>
                                            <input type="date" class="form-control" value="{{ $to }}"
                                                name="to">
                                        </div>
                                    </div>


                                    <button type="submit" class="btn btn-primary">
                                        Filter
                                    </button>
                                    <a href="{{ route('admin.retailer.retailer-withdrawals', ['user' => $user]) }}"
                                        class="btn btn-primary">Reset</a>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <br>
                <div class="row hidden-print">
                    <div class="col-md-4">
                        <div class="widget widget-tile hidden-print" style="background: #277fbf">
                            <div class="data-info">
                                <div class="desc text-white font-bolder">
                                    Total Paid ({{ $stats['paid']['count'] }})
                                </div>
                                <div class="value">
                                    <span class="text-white font-bolder"></span>
                                    <span class="text-white font-bolder">{{ $stats['paid']['total'] }}</span>
                                </div>
                            </div>
                            <div class="chart sparkline" id="spark1">
                                <span class="icon voyager-dollar text-white font-bolder"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="widget widget-tile hidden-print" style="background: #277fbf">
                            <div class="data-info">
                                <div class="desc text-white font-bolder ">

                                    Pending ({{ $stats['pending']['count'] }})
                                </div>
                                <div class="value">
                                    <span class="text-white font-bolder"></span>
                                    <span class="text-white font-bolder">{{ $stats['pending']['total'] }}</span>
                                </div>
                            </div>
                            <div class="chart sparkline" id="spark1">
                                <span class="icon voyager-dollar text-white font-bolder"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="widget widget-tile hidden-print" style="background: #277fbf">
                            <div class="data-info">
                                <div class="desc text-white font-bolder">
                                    Canceled ({{ $stats['canceled']['count'] }})
                                </div>
                                <div class="value">
                                    <span class="text-white font-bolder"></span>
                                    <span class="text-white font-bolder">{{ $stats['canceled']['total'] }}</span>
                                </div>
                            </div>
                            <div class="chart sparkline" id="spark1">
                                <span class="icon voyager-dollar text-white font-bolder"></span>
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
                                        <td colspan="4">
                                            <button class="btn btn-primary hidden-print"
                                                onclick="window.print()">Print</button>


                                            @if ($user)
                                                <!-- Modal trigger button -->
                                                <button type="button" class="btn btn-primary bg-primary btn-lg"
                                                    data-toggle="modal" data-target="#withdrawModal">
                                                    Withdraw Balance</button>
                                                </button>
                                            @endif

                                            <!-- Modal Body -->
                                            @if ($user)
                                                <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-backdrop and data-keyboard -->
                                                <div class="modal fade" id="withdrawModal" tabindex="-1"
                                                    data-backdrop="static" data-keyboard="false" role="dialog"
                                                    aria-labelledby="modalTitleId" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md"
                                                        role="document">
                                                        <div class="modal-content">

                                                            <div class="modal-body">

                                                                <form
                                                                    action="{{ route('admin.retailer.retailer-withdrawals-balance', $user) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    <div class="modal-body">
                                                                        <div class="form-group">
                                                                            <label for="amount">Amount (<span
                                                                                    class="font-weight-bold">Available for
                                                                                    withdraw
                                                                                    {{ $user->totalBalance() }}NOK</span>)</label>
                                                                            <input id="amount" type="number"
                                                                                class="form-control" name="amount"
                                                                                required>
                                                                            
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="trnx_id">Trnx ID</label>
                                                                            <input id="trnx_id" type="text"
                                                                                class="form-control" name="trnx_id"
                                                                                required>
                                                                            
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="date">Date</label>
                                                                            <input id="date" type="date" value="{{now()->format('Y-m-d')}}"
                                                                                class="form-control" name="date"
                                                                                required>
                                                                            
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Close</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Withdraw</button>
                                                                    </div>
                                                                </form>

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Optional: Place to the bottom of scripts -->


                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Date
                                        </th>
                                        <th>
                                            Amount
                                        </th>
                                        <th>
                                            Trnx ID
                                        </th>
                                        <th>
                                           Withdraw Date
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Action
                                        </th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($withdrawals as $withdrawal)
                                        <tr>
                                            <td>
                                             {{$withdrawal->id}}   {{ $withdrawal->created_at->format('d-m-Y') }}
                                            </td>
                                            <td>
                                                {{ $withdrawal->amount }} NOK
                                            </td>
                                            <td>
                                                {{ $withdrawal->trnx_id }} 
                                            </td>
                                            <td>
                                                {{ $withdrawal->date }}
                                            </td>
                                            <th>
                                                {{ $withdrawal->status() }}
                                            </th>
                                            <th>
                                                @if ($withdrawal->status == 0)
                                                    @if ($withdrawal->user->retailer->bank_account_number)
                                                        <a href="{{ route('admin.retailer.withdraw.approve', $withdrawal) }}"
                                                            data-bank="{{ $withdrawal->user->retailer->bank_account_number }}"
                                                            class="btn btn-sm btn-success"
                                                            onclick="message(this,{{ $withdrawal->user->hasBankAccount() }})">Approve</a>
                                                    @else
                                                        <a target="_blank" class="btn btn-danger"
                                                            href="{{ route('voyager.retailer-metas.edit', [$withdrawal->user->retailer->id]) }}">Update
                                                            Bank account</a>
                                                    @endif
                                                    <a href="{{ route('admin.retailer.withdraw.cancel', $withdrawal) }}"
                                                        class="btn btn-sm btn-warning">Cancel</a>
                                                @endif
                                            </th>

                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="4">
                                            {{-- {{ $withdrawals->links() }} --}}
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('javascript')
    <script>
        function message(e, status) {
            event.preventDefault();
            if (status) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to transfer money to this (" + e.dataset.bank + ") account!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire(
                            'Done',
                            'Withdrawal is accepted.',
                            'success'
                        )
                        location.href = e.href;
                    }
                })
            }


        }
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
