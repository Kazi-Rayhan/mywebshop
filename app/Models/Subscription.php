<?php

namespace App\Models;

use App\Models\Traits\HasCharges;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory, HasCharges;
    protected $guarded = [];
    public $additional_attributes = ['title', 'domain'];

    

    public function getTitleAttribute()
    {
        return $this->subscribable->title;
    }


    public function subscribable()
    {
        return $this->morphTo();
    }



    public function order()
    {
        return $this->belongsTo(Order::class, 'key', 'payment_id');
    }

    public function charges()
    {
        return $this->hasMany(SubscriptionCharge::class);
    }

    public function fee()
    {
        return $this->subscribable->fee();
    }
    public function feeDetails()
    {
        return $this->subscribable->details();
    }
}
