<?php

namespace App\Models;

use App\Models\Traits\Bookable;
use App\Models\Traits\HasMeta;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory, HasMeta;
    protected $meta_attributes = [
        'target',

    ];
    protected $fillable = [
        'title', 'sessions', 'price', 'details', 'shop_id', 'tax', 'validity', 'type', 'split'
    ];

    protected $casts = [
        'pt_package_purchase_history' => 'array'
    ];

    public function levels()
    {
        return $this->belongsToMany(Level::class)->withPivot('price');
    }
    public function getPrice($manager = null, $split = false)
    {
        if ($manager) {
            $model = User::find($manager);
            $price = $this->levels()->find($model->level)->pivot->price ?? $this->price;
        } else {
            $price = $this->price ?? 0;
        }

        if ($this->split && $split) {
            return $price / $this->split;
        } else {
            return $price;
        }
    }
    public function getTax($manager = null, $split = false)
    {
        return ($this->getPrice($manager, $split) * $this->tax) / 100;
    }
    public function shop()
    {
        return $this->belongsTo(Shop::class)->withDefault();
    }


    public function getDuration($split = false)
    {
        $package = $this->shop->defaultoption;

        $duration =  $this->sessions * $package->minutes;
        if ($this->split && $split) {
            return round($duration / $this->split);
        } else {
            return $duration;
        }
    }

    public function getDurationAttribute()
    {
        $package = $this->shop->defaultoption;

        return  $this->sessions * $package->minutes;
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function validity(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value != 0 ? $value : $this->shop->package_validity
        );
    }
}
