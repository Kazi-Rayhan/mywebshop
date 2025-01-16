<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditHistory extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'credit_histories';
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function rate_per_session()
    {

        return $this->price / $this->package->sessions;
    }
}
