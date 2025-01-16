@php
use App\Models\User;
    if ($manager instanceof \Illuminate\Support\Collection) {
        $ids = $manager->pluck('id')->toArray();
    }else{
        $ids = [$manager->id];
    }
    $users = User::whereHas('metas', function ($query) use ($manager,$ids) {
            $query->where('column_name', 'personal_trainner')->whereIn('column_value', $ids);
        })->whereHas('metas',function($query) use ($manager){
            $query->where('column_name', 'free_credits');
        })->get();
    if($users->count() >0){
        $usersWithOrders = $users->filter(function ($user) {
            return $user->orders->count() > 0;
        });
        $ordersuser =$usersWithOrders->count();
        $percent = round(($ordersuser / $users->count()) * 100);
    }else{
        $ordersuser =0;
        $percent =0;
    }
@endphp
<div class="col-lg-4 col-md-6 col-6">

    <div class="small-box bg-primary">
        <div class="inner">
            <div class="d-flex">
                <h3 class="mr-2">{{ $ordersuser }}</h3>
                <h5>{{ $percent }}%</h5>
            </div>
            <p>{{ __('words.reslae') }}</p>
        </div>
        <div class="icon">
            <i style="font-size:40px" class="fas fa-cart-arrow-down"></i>
        </div>

    </div>
</div>
