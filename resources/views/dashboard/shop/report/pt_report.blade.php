<x-dashboard.shop>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/adminlte.min2167.css') }}">
        <style>
            .users-list>li {
                width: 33%;
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-md-12">
            <h3><span class="text-primary opacity-25">{{ __('words.pt_report_sec_title') }} </h3>
        </div>
        <div class="col-md-12">

            <form action="{{ url()->current() }}" method="get">
                <div class="form-group ">
                    <label for="">
                        {{ __('words.prsonal_trainer') }}
                    </label>
                    <select name="manager" class="form-control" id="">
                        <option value="">{{ __('words.all') }}</option>
                        @foreach ($allManagers as $manager)
                            <option @if (request()->manager == $manager->id) selected @endif value="{{ $manager->id }}">
                                {{ $manager->fullName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>
                                {{ __('words.from') }}
                            </label>
                            <input value="{{ request('from') }}" type="date" class="form-control" name="from">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>
                                {{ __('words.to') }}
                            </label>
                            <input type="date" value="{{ request('to') }}" class="form-control" name="to">
                        </div>
                    </div>
                </div>
                <div class="d-flex gap-2 mb-2">
                    <button class="btn btn-success mr-2" style="float:right">
                        <i class="fa fa-filter"></i> {{ __('words.filter') }}
                    </button>
                    <a href="{{ route('shop.pt.report') }}" class="btn btn-warning">{{ __('words.reset') }}</a>
                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal"
                        data-bs-target="#modalId">
                        <i class="fa fa-download"></i> {{ __('words.download_pdf') }}
                    </button>
                </div>


            </form>
        </div>
        <div class="col-md-12">

            <div class="row">

                @foreach ($report as $key => $value)
                    <div class="col-md-4 ">
                        <x-report :key="$key" :value="$value" />
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-7">
                    <x-reports.index :orders="$orders" />
                </div>
                <div class="col-md-5">
                    <x-reports.managers :manager="$managers" />
                </div>
                @php
                    $shop = auth()
                        ->user()
                        ->getShop();
                    $inactives = App\Models\User::whereHas('credits', function ($query) use ($manager, $shop) {
                        $query->whereIn('trainer_id', $manager->pluck('id')->toArray())->where('updated_at', '>=', now()->subDays($shop->inactive_days));
                    })->paginate(10);
                    $bookings = App\Models\Booking::where('shop_id', $shop->id)
                        ->whereIn('manager_id', $manager->pluck('id'))
                        ->where('status', 1)
                        ->where('show_up', 0)
                        ->paginate(10);
                @endphp
                <div class="col-md-12">
                    <x-reports.users :users="$inactives" :title="__('words.inactive_clients')" />
                </div>
                <div class="col-md-12">
                    <x-reports.bookings :bookings="$bookings" :title="__('words.bookings')" />
                </div>
            </div>
        </div>
    </div>

    <!-- Modal trigger button -->


    <!-- Modal Body -->
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div class="modal fade" id="modalId" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
            <form action="{{ route('shop.pt.report.pdf', request()->all()) }}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitleId">{{ __('words.show_report') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="manager" value="{{ request()->manager }}">
                        <input type="hidden" name="from" value="{{ request()->from }}">
                        <input type="hidden" name="to" value="{{ request()->to }}">
                        <div class="row ">
                            @foreach ([
        'dashboard_total_sale',
        'session_sold',
        'reslae',
        // 'dashboard_customers',
        'completed_hours',
        'outstanding-sessions',
        'sessions_last_week_complete',
        'sessions_this_month_complete',
        'coverage',
        'inactive_clients',
        'bookings_do_not_show_up',
        'inactive_client_list',
        'bookings_do_not_show_up_list',
    ] as $col)
                                <div class="col-md-6">
                                    <x-form.input type="checkbox" value="{{ $col }}" name="report[]"
                                        checked="true" :label="__('words.' . $col)" />
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary mb-2"> <i class="fa fa-download"></i>
                            {{ __('words.download_pdf') }}</button>
                    </div>
            </form>
        </div>
    </div>
    </div>


    <!-- Optional: Place to the bottom of scripts -->
    <script>
        const myModal = new bootstrap.Modal(document.getElementById('modalId'), options)
    </script>
    <script>
        function print_report(divName) {
            var printContents = document.getElementById('print_report').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
    </script>


</x-dashboard.shop>
