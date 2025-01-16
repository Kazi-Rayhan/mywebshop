<x-dashboard.manager>
<h3 class="d-print-none">{!! __('words.reports_sec_title') !!}</h3>
<div class="row mt-3 d-print-none">
    <div class="col ">
        <div class="card">
            <div class="card-body">
                <form action="{{route('manager.report')}}" method="get">


                    <div class="row row-cols-2">
                        <div class="col">
                            <div class="form-group">
                                <label for="from">{!! __('words.from') !!}</label>
                                <input type="date" class="form-control" @if(request()->filled('from')) value="{{Carbon\Carbon::parse(request()->from)->format('Y-m-d')}}" @endif name="from">
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="to">{!! __('words.to') !!}</label>
                                <input type="date" class="form-control" @if(request()->filled('to')) value="{{Carbon\Carbon::parse(request()->to)->format('Y-m-d')}}" @endif name="to">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        {!!__('words.filter_btn') !!}
                    </button>
                    <a href="{{route('manager.report')}}" class="btn btn-primary">{!! __('words.reset_btn') !!}</a>

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
                            <button class="btn btn-primary d-print-none" onclick="window.print()"><i class="fa fa-print" aria-hidden="true"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {!! __('words.date') !!}
                        </th>
                        <th>
                            {!! __('words.sell') !!}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sells as $date => $total)
                    <tr>
                        <td>
                            {{$date}}
                        </td>
                        <td>
                            {{$total}} NOK
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td>
                            {{ __('words.cart_account_table_title') }}
                        </td>
                        <td>
                            {{$sells->sum()}} NOK
                        </td>
                    </tr>
                </tbody>

            </table>
        </div>
    </div>
</div>
</x-dashboard.manager>