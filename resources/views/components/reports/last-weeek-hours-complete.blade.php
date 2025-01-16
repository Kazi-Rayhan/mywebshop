<?php

use Illuminate\Support\Collection;
if ($manager instanceof \Illuminate\Support\Collection) {
        $ids = $manager->pluck('id')->toArray();
    }else{
        $ids = [$manager->id];
    }

    $this_week_complete =App\Models\Booking::whereIn('manager_id', $ids)
        ->where('service_type', 1)
        ->whereBetween('end_at', [now()->startOfWeek(), now()->endOfWeek()])
        ->sum(DB::raw('TIMESTAMPDIFF(MINUTE, start_at, end_at)'));


$option = auth()
    ->user()
    ->getShop()->defaultOption;
if ($option) {
    $result = round($this_week_complete / $option->minutes);
} else {
    $result = 0;
}
?>

<div class="col-lg-4 col-md-6 col-6">
    <div class="small-box bg-primary">
        <div class="inner pb-2">
            <h3>{{ $result }}</h3>
            <p>{{ __('words.sessions_last_week_complete') }}</p>
        </div>
        <div class="icon">
            <i style="font-size:40px" class="far fa-clock"></i>
        </div>
    </div>
</div>
