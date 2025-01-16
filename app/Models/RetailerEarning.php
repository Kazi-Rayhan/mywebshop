<?php

namespace App\Models;

use App\Models\Traits\HasMeta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetailerEarning extends Model
{
    use HasFactory, HasMeta;
    protected $guarded = [];

    protected $meta_attributes = ['details'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAmountAttribute($value)
    {
        return $value / 100;
    }

    public function setAmountAttribute($value)
    {
        $this->attributes['amount'] =  $value * 100;
    }
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
