<?php

namespace App\Models;

use App\Models\Shop;
use Illuminate\Database\Eloquent\Model;


class Membership extends Model
{
    protected $guarded = [];
    protected $casts = ['paid_at'=>'datetime'];

    
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function subscriptionFee()
    {

        if($this->establisment_status == 1) return $this->box->price;
        return $this->box->price + $this->box->est_cost;
        
    }

    public function box(){
        return $this->belongsTo(Box::class);
    }
    public function status($key=0)
    {
        return [
            0=>'Avventer',
            1=>'løping',
            2=>'Kansellert',
        ][$this->status];
    }
    public function charges(){
        return $this->hasMany(MembershipCharge::class);
    }
}
