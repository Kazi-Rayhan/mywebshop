@php

    use Illuminate\Support\Collection;
    use App\Models\{Credit, Booking};

    if ($manager instanceof \Illuminate\Support\Collection) {
        $ids = $manager->pluck('id')->toArray();
    }else{
        $ids = [$manager->id];
    }
    $minutes = Credit::whereIn('trainer_id',$ids)->selectRaw('SUM(demo_credits) as total_demo_credits')
    ->selectRaw('SUM(manager_credits) as total_manager_credits')
    ->selectRaw('SUM(admin_credits) as total_admin_credits')
    ->selectRaw('SUM(subscription_credits) as total_subscription_credits')
    ->selectRaw('SUM(session_credits) as total_session_credits')
    ->first();

    $option = auth()
        ->user()
        ->getShop()->defaultOption;
    if ($option) {
        $result = round(($minutes->total_manager_credits + $minutes->total_admin_credits + $minutes->total_subscription_credits + $minutes->total_session_credits ) / $option->minutes);
    } else {
        $result = 0;
    }
@endphp

<div class="col-lg-4 col-md-6 col-6">
    <div class="small-box bg-primary">
        <div class="inner ">
            <h3>{{ $result }}</h1>
                <p>{{ __('words.outstanding-sessions') }} </p>
        </div>
        <div class="icon">
            <i style="font-size:40px" class="far fa-clock"></i>
        </div>
        <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
    </div>
</div>
