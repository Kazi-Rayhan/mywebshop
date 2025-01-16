<?php

namespace App\Models;

use Dotenv\Parser\Value;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function locations() :Attribute{
        return Attribute::make(
            get : fn($value) => json_decode($value)
        );
    }

    public function costWithTax(){
        return $this->shipping_cost + (($this->shipping_cost * $this->shop->tax)/100);
    }

    public function shop(){
        return $this->belongsTo(Shop::class);
    }
}

