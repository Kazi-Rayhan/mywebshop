<?php
use Illuminate\Support\Collection;
use App\Models\User;

if ($manager instanceof Collection) {
    $users = User::whereIn('pt_trainer_id', $manager->pluck('id')->toArray());
} else {
    $users = User::where('pt_trainer_id', $manager->id);
}
$users = $users->take(12)->get();

?>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">{{ __('words.dashboard_members_table_title') }}</h3>
    </div>

    <div class="card-body p-0">
        <ul class="users-list clearfix">
            @foreach ($users as $user)
                <li>
                    <img src="{{ Iziibuy::image($user->avatar) }}" alt="{{ Str::limit($user->fullName, 5) }}'s image"
                        style="width:40px;height:40px">
                    <a class="users-list-name"
                        href="{{ route('manager.booking.book', [$user,auth()->user()->getShop()->defaultoption]) }}">{{ $user->fullName }}</a>
                    <span class="users-list-date">{{ $user->created_at->format('d M') }}</span>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="card-footer text-center">

        <a href="{{ route('manager.booking.client.index') }}"> {{ __('words.dashboard_all_View') }}</a>
    </div>

</div>
