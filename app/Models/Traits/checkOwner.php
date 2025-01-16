<?php

namespace App\Models\Traits;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Builder;

trait checkOwner
{

    protected static function booted(): void
    {
        static::addGlobalScope('checkOwner', function (Builder $builder) {
            $user = auth()->user();

            if (isset(request()->user_name)) {
                $builder->when(isset(request()->user_name), function ($query) {

                    $shopId = Shop::where('user_name', request()->user_name)->value('id');

                    return $query->where('shop_id', $shopId);
                });
            } else {
                if ($user && $user->role->name == 'vendor') {
                    $builder->where('shop_id', $user->shop->id);
                }
            }
        });
    }
}
