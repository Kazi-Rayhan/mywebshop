<?php
use Illuminate\Support\Collection;
use App\Models\User;

if ($manager instanceof \Illuminate\Support\Collection) {
    $ids = $manager->pluck('id')->toArray();
} else {
    $ids = [$manager->id];
}
$q = User::whereIn('pt_trainer_id', $ids)->whereHas('credits',function($q){
    $q->where('shop_id',auth()->user()->getShop()->id)->where(function($query){
        $query->hasFreeCredits();
    });
});

$customers = [
    'total' => $q->count()
];

$sessions_sold_total_price = (clone $q)
    ->join('credits', function ($join) {
        $join->on('users.id', '=', 'credits.user_id')->join('subscriptions', function ($join) {
            $join->on('credits.id', '=', 'subscriptions.subscribable_id')->join('subscription_charges', function ($join) {
                $join->on('subscriptions.id', '=', 'subscription_charges.subscription_id');
            });
        });
    })
    ->sum('amount');

$n_q = (clone $q)->join('credits', function ($join) {
    $join->on('users.id', '=', 'credits.user_id');
});
$sessions_credits = $n_q->sum('free_credit');
$option = auth()
    ->user()
    ->getShop()->defaultOption;
if ($option) {
    $result = round($sessions_credits / $option->minutes);
} else {
    $result = 0;
}

?>

<div class="col-lg-4 col-md-6 col-6">
    <div class="small-box bg-primary">
        <div class="inner ">
            <h3>{{ $customers['active'] }} / {{ $customers['total'] }}</h3>
            <p>{{ __('words.free_tire_customer') }}1</p>
        </div>
        <div class="icon">
            <i style="font-size:40px" class="fas fa-users"></i>
        </div>
    </div>
</div>
<div class="col-lg-4 col-6">
    <div class="small-box bg-primary">
        <div class="inner ">
            <h3>{{ Iziibuy::money_format($sessions_sold_total_price) }}NOK</h3>
            <p>{{ __('words.free_tire_customer_selling_price') }}2</p>
        </div>
        <div class="icon">
            <i style="font-size:40px" class="fas fa-dollar-sign"></i>
        </div>
    </div>
</div>
<div class="col-lg-4 col-6">
    <div class="small-box bg-primary">
        <div class="inner ">
            <h3>{{ $result }}</h3>
            <p>{{ __('words.free_tire_customer_sessions') }}3</p>
        </div>
        <div class="icon">
            <i style="font-size:40px" class="far fa-clock"></i>
        </div>
    </div>
</div>
