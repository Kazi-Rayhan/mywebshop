<x-dashboard.manager>
    <h3><span class="text-primary opacity-25">{!! __('words.manager_budget_sec_title') !!}</span> {{ __('words.budget') }}</h3>
    <div class="container">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <form action="{{ route('manager.commisssions.index') }}" method="get">


                        <div class="row row-cols-2">
                            <div class="col">
                                <div class="form-group">
                                    <label for="from">{!! __('words.from') !!}</label>

                                    <input type="date" class="form-control"
                                        value="{{ request()->filled('from')? Carbon\Carbon::parse(request()->from)->format('Y-m-d'): now()->startOfMonth()->format('Y-m-d') }}"
                                        name="from">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="to">{!! __('words.to') !!}</label>
                                    <input type="date" class="form-control"
                                        value="{{ request()->filled('from') ? Carbon\Carbon::parse(request()->to)->format('Y-m-d') : now()->format('Y-m-d') }}"
                                        name="to">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            {!! __('words.filter_btn') !!}
                        </button>
                        <a href="{{ route('manager.commisssions.index') }}"
                            class="btn btn-primary">{!! __('words.reset_btn') !!}</a>

                    </form>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table">

                            <thead>

                                <tr>
                                    <th>{{ __('words.package') }}</th>


                                    <th>{{ __('words.appointment') }}</th>
                                    <th>{{ __('words.sum') }}</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($bookings as $booking)
                                    <tr>
                                        <td>
                                            {{ $booking->commission_type }}
                                        </td>

                                        <td>
                                            {{ round($booking->total_minutes /auth()->user()->getShop()->defaultoption->minutes) }}
                                        </td>

                                        <td>
                                            {{ $booking->total_commission ?? 0 }} NOK
                                        </td>

                                    </tr>
                                @endforeach
                                <tr>
                                    <th colspan="2">
                                        {{ __('words.bonus') }}
                                    </th>
                                    <th>

                                        {{ $bonus }} NOK
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="2">
                                        {{ __('words.total') }}
                                    </th>
                                    @php
                                        $total = ($bookings->sum('total_commission') ?? 0) + $bonus;
                                    @endphp
                                    <th>
                                        {{ $total }} NOK
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="2">
                                        {{ __('words.target') }}
                                    </th>
                                    <th>
                                        {{ auth()->user()->target }} NOK
                                    </th>
                                </tr>
                                <tr>
                                    <th colspan="2">
                                        {{ __('words.total') }} - {{ __('words.target') }}
                                    </th>
                                    <th>
                                        {{ $total - auth()->user()->target ?? 0 }}
                                        NOK
                                    </th>
                                </tr>


                            </tbody>
                        </table>
                    </div>


                </div>

            </div>
        </div>


    </div>


    </div>
</x-dashboard.manager>
