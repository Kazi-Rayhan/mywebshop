<x-dashboard.shop>
    <h3><span class="text-primary opacity-25"><i class="fas fa-dice-d6" aria-hidden="true"></i></span>
        {{ __('words.copuon_create_sec_title') }}
    </h3>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('shop.coupon.store') }}" method="post">
                        @csrf
                        <x-form.input type="text" name="code" label="{!! __('words.coupon_code') !!}"
                            value="{{ old('code') }}" />
                        <x-form.input type="number" name="discount" label="{!! __('words.invoice_dis_amount') !!}"
                            value="{{ old('discount') }}" />
                        <x-form.input type="date" name="expire_at" label="{!! __('words.coupon_expire_at') !!}"
                            value="{{ old('expire_at') }}" />
                        <x-form.input type="number" name="limit" label="{!! __('words.coupon_limit') !!}"
                            value="{{ old('limit') }}" />
                        <x-form.input type="number" name="minimum_cart" label="{!! __('words.coupon_min_cart') !!}"
                            value="{{ old('minimum_cart') }}" />
                        <button class="btn btn-primary"> <i class="fa fa-plus-square" aria-hidden="true"></i>
                            {!! __('words.save_btn') !!}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-dashboard.shop>
