<?php
use Illuminate\Support\Collection;
use App\Models\User;
if ($manager instanceof \Illuminate\Support\Collection) {
        $ids = $manager->pluck('id')->toArray();
    }else{
        $ids = [$manager->id];
}
$total = App\Models\Booking::whereIn('manager_id', $ids)
        ->where('end_at', '<',now())
        ->where('service_type', 1)
        ->sum(DB::raw('TIMESTAMPDIFF(MINUTE, start_at, end_at)'));

$option = auth()
    ->user()
    ->getShop()->defaultOption;
if ($option) {
    $result = round($total / $option->minutes);
} else {
    $result = 0;
}

?>

<div class="col-lg-4 col-md-6 col-6">
    <div class="small-box bg-primary">
        <div class="inner">
            <h3>{{$result}}</h3>
            <p>{{__('words.completed_hours')}}</p>
        </div>
        <div class="icon">
            <i style="font-size:40px" class="far fa-clock"></i>
        </div>
    </div>
</div>
