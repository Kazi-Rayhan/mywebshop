<?php
use Illuminate\Support\Collection;
use App\Models\User;

if ($manager instanceof Collection) {
    $q = User::whereIn('pt_trainer_id', $manager->pluck('id')->toArray());
} else {
    $q = User::where('pt_trainer_id', $manager->id);
}
$newq = clone $q;
$active = $newq->whereHas('credits',function($query){
    $query->hasCredits();
})->count();

$customers = $q->count();
?>

<div class="col-lg-4 col-md-6 col-6">
    <div class="small-box bg-primary">
        <div class="inner ">
            <h3>{{ $active }} / {{ $customers }}</h3>
            <p>{{ __('words.dashboard_customers') }}</p>
        </div>
        <div class="icon">
            <i style="font-size:40px" class="far fa-clock"></i>
        </div>
    </div>
</div>
