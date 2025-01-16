@php
    use Illuminate\Support\Collection;
    use App\Models\{User, Booking, Credit};
    if ($manager instanceof Collection) {
        $ids = $manager->pluck('id')->toArray();
    } else {
        $ids = [$manager->id];
    }
    $total = App\Models\Booking::whereIn('manager_id', $ids)
        ->where('service_type', 1)
        ->where('end_at', '<',now())
        ->sum(DB::raw('TIMESTAMPDIFF(MINUTE, start_at, end_at)'));

    $minutes = Credit::whereIn('trainer_id', $ids)->sum('history');

    if ($minutes && $total) {
        $percent = round(($total / $minutes) * 100);
    } else {
        $percent = 0;
    }
@endphp
<div class="col-lg-4 col-md-6 col-6">

    <div class="small-box bg-primary">
        <div class="inner">
            <div class="d-flex">
                <h3 class="mr-2">{{ $percent }}%</h3>

            </div>
            <p>{{ __('words.coverage') }}</p>
        </div>
        <div class="icon">
            <i style="font-size:40px" class="fas fa-percent"></i>
        </div>

    </div>
</div>
