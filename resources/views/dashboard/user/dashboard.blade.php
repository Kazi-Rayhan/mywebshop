<x-dashboard.user>
    <h3>{{ __('words.dashboard') }}</h3>
    <div class="row row-cols-md-2 row-cols-lg-3  row-cols-1">

        <div class="card p-3  bg-transparent  border-0 ">
            <div class="card-body content">
                <h2>
                    {{ $order }}
                </h2>
                <h4 class="text-right mt-4" style="color:var(--brandcolor)">
                    <i class="fa fa-file-invoice mr-2"></i> {{ __('words.dashboard_order_title') }}
                </h4>
            </div>
        </div>


        <div class="card p-3  bg-transparent  border-0 ">
            <div class="card-body content">
                <h2>
                    {{ $booking }}
                </h2>
                <h4 class="text-right mt-4" style="color:var(--brandcolor)">
                    <i class="fa fa-calendar mr-2"></i> {{ __('words.booking') }}
                </h4>
            </div>
        </div>


    </div>
</x-dashboard.user>
