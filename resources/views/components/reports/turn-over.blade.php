<div class="col-lg-4 col-md-6 col-6">
    <div class="small-box bg-primary">
        <div class="inner">
            <h3>{{ Iziibuy::money_format($orders->sum('total'))}}NOK</h3>
            <p>{{ __('words.dashboard_total_sale') }}</p>
        </div>
        <div class="icon">
            <i style="font-size:40px" class="fas fa-cart-arrow-down"></i>
        </div>
    </div>
</div>
