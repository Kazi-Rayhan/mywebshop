@php

    use Illuminate\Support\Collection;
    use App\Models\Credit;
    if ($manager instanceof Collection) {
        $credit = Credit::whereIn('trainer_id', $manager->pluck('id')->toArray())->get();
        $minutes = $credit->sum('history') - $credit->sum('free_credit');
    } else {
        $credit = Credit::where('trainer_id', $manager->id)->get();
        $minutes = $credit->sum('credits') - $credit->sum('free_credit');
    }
    $option = auth()->user()->getShop()->defaultOption;
    if($option){
    $result = round($minutes / $option->minutes);

    }else{
        $result = 0;
    }
@endphp
<div class="col-lg-4 col-md-6 col-6">
    <div class="small-box bg-primary">
        <div class="inner ">
            <h3>{{ $result }}</h1>
            <p>{{__('words.session_sold')}} </p>
        </div>
        <div class="icon">
            <i style="font-size:40px" class="far fa-clock"></i>
        </div>
        <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
    </div>
</div>
