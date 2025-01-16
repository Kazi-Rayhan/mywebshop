<x-dashboard.retailer>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-stats mb-4 p-3">
                            <x-qr.direct :size="250" :url="route('shop.register', ['refferal' => auth()->id()])" :disabled="true" />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-stats mb-4 p-3">
                            <ul class="list-group">
                                <li class="list-group-item">{{ __('words.retailer_total_eraning') }} :
                                    <strong>{{ auth()->user()->totalEarning() }}</strong> NOK
                                </li>
                                <li class="list-group-item">{{ __('words.retailer_total_withdrawa') }} :
                                    <strong>{{ auth()->user()->totalWithdrawal() }}</strong> NOK
                                </li>
                                <li class="list-group-item">{{ __('words.retailer_total_balance') }} :
                                    <strong>{{ auth()->user()->totalBalance() }}</strong> NOK
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                <a href="https://www.youtube.com/playlist?list=PLcxIFCbE9hcA2n-K5wjlNj8kiOeaK2umQ"
                    target="_blank">{{ __('words.youtube_training') }}</a>
            </div>
        </div>
    </div>
</x-dashboard.retailer>
