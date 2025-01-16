<?php
use Illuminate\Support\Collection;
use App\Models\User;

if ($manager instanceof Collection) {
    $customers = User::whereIn('pt_trainer_id', $manager->pluck('id')->toArray())->where('created_at','>',now()->startOfWeek())->count();
} else {
    $customers = User::where('pt_trainer_id', $manager->id)->where('created_at','>',now()->startOfWeek())->count();
}

?>

<div class="col-lg-4 col-md-6 col-6">

    <div class="small-box bg-primary">
        <div class="inner">

            <h3>{{$customers}}</h3>
            <p>{{ __('words.new_contract') }} </p>
        </div>
        <div class="icon">
            <i style="font-size:40px" class="fas fa-file-contract"></i>
        </div>
        <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
    </div>
</div>
