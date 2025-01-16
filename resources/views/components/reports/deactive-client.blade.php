@php


    use Illuminate\Support\Collection;
    use App\Models\{Credit, Booking};

    if ($manager instanceof \Illuminate\Support\Collection) {
        $ids = $manager->pluck('id')->toArray();
    }else{
        $ids = [$manager->id];
    }
    $clients = Credit::whereIn('trainer_id',$ids)->where(function($query){
        $query->hasCredits()->whereDate('updated_at', '<' ,now()->subMonth());
    })->count();

    
@endphp

<div class="col-lg-4 col-md-6 col-6">
    <div class="small-box bg-primary">
        <div class="inner ">
            <h3>{{ $clients }}</h1>
                <p>{{ __('words.inactive ') }} </p>
        </div>
        <div class="icon">
            <i style="font-size:40px" class="far fa-clock"></i>
        </div>
        <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
    </div>
</div>
