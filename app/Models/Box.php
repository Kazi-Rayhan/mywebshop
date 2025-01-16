<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;


class Box extends Model
{
    protected $guarded = [];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'box_product')->withTimestamps();
    }

    public function path()
    {
        return route('subscription-box', [request()->user_name, $this]);
    }
    public function memberships()
    {
        return $this->hasMany(Membership::class);
    }

    public function getDurationAttribute($values)
    {
        return json_decode($values)  ;
    }
    public function  checkOut()
    {
        $membership = $this->memberships()->where('user_id', auth()->id())->first();
        if (auth()->check() &&  $membership) {

            return $membership->payment_url ?? route('subscription-box-subscribe', [request()->user_name, $this->id]);
        }
        return route('subscription-box-subscribe', [request()->user_name, $this->id]);
    }
}
