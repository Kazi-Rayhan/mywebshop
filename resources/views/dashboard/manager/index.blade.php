<x-dashboard.manager>

    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/adminlte.min2167.css') }}">
        <style>
        </style>
    @endpush
    <div class="row">
        <div class="col-md-3">
            <h3><span class="text-primary opacity-25">{{ __('words.dashboard_welcome') }} </h3>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-stats mb-4 p-3">
                            <x-qr.direct :size="150" :url="route('shop.home', [
                                'user_name' => auth()
                                    ->user()
                                    ->getShop()->user_name,
                                'manager_id' => auth()->id(),
                            ])" />
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card card-stats mb-4 ">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title text-uppercase text-muted mb-0">
                                            {{ __('words.products_sec_title') }}
                                        </h5>
                                        <span class="h1 font-weight-bold mb-0"></span>
                                    </div>
                                    <div class="col-auto">
                                        <div class="bg-primary text-center text-white rounded-circle shadow"
                                            style="height:25px;width:25px">
                                            <i class="fa fa-shopping-bag"></i>
                                        </div>
                                    </div>
                                </div>
                                <a class="btn btn-outline-primary  float-right"
                                    href="{{ route('manager.products') }}">{{ __('words.view_btn') }}</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        {{ __('words.dashboard_name') }}
                                    </th>
                                    <th>
                                        {{ __('words.dashboard_credits') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    @if ($user->user)
                                        @if (!$user->credits <= 0 && !Carbon\Carbon::now()->diffInMonths($user->updated_at) >= 1)
                                            <tr>


                                                <td>
                                                    <a
                                                        href="{{ route('manager.booking.client.edit', $user->user) }}">{{ $user->user->name }}</a>
                                                </td>
                                                <td
                                                    class="
                                            @if ($user->credits <= 100) text-danger
                                            @elseif($user->credits <= 500) text-warning
                                            @else text-success @endif

                                            ">
                                                    {{ $user->credits /auth()->user()->getShop()->defaultOption->minutes ?:1 }}
                                                    {{ __('words.sessions') }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endif
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
        <div class="col-md-9">
            <div class="row">
                @foreach ($report as $key => $value)
                    <div class="col-md-4 ">
                        <x-report :key="$key" :value="$value" />
                    </div>
                @endforeach

            </div>
            <div class="row">
                <div class="col-md-8">
                    <x-reports.index :orders="$orders" />
                </div>
                <div class="col-md-4">
                    <x-reports.clients :manager="$manager" />
                    <x-widget :manager="$manager" />


                </div>
            </div>
        </div>
    </div>
</x-dashboard.manager>
