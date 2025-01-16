<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Iziibuy;
use Illuminate\Support\Facades\Cache;
class Language extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function english(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $shop = Iziibuy::getShop();
                if ($shop) {
                    return @$this->shops()->find($shop->id)?->pivot->english ?? $value;
                } else {
                    return $value;
                }
            }
        );
    }
    public function spanish(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $shop = Iziibuy::getShop();
                if ($shop) {
                    return @$this->shops()->find($shop->id)?->pivot->spanish ?? $value;
                } else {
                    return $value;
                }
            }
        );
    }
    public function norwegian(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                $shop = Iziibuy::getShop();
                if ($shop) {
                    return @$this->shops()->find($shop->id)?->pivot->norwegian ?? $value;
                } else {
                    return $value;
                }
            }
        );
    }

    public function englishOptions(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => json_encode(explode(',', $value)),
            get: fn ($value) =>  $value ? implode(',', json_decode($value)) : '',
        );
    }
    public function spanishOptions(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => json_encode(explode(',', $value)),
            get: fn ($value) =>  $value ? implode(',', json_decode($value)) : '',
        );
    }
    public function norwegianOptions(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => json_encode(explode(',', $value)),
            get: fn ($value) =>  $value ? implode(',', json_decode($value)) : '',
        );
    }


    public function englishOptionsArray(): Attribute
    {
        return Attribute::make(

            get: fn ($value) =>  json_decode($this->attributes['english_options']),
        );
    }
    public function spanishOptionsArray(): Attribute
    {
        return Attribute::make(

            get: fn ($value) =>   json_decode($this->attributes['spanish_options']),
        );
    }
    public function norwegianOptionsArray(): Attribute
    {
        return Attribute::make(

            get: fn ($value) =>  json_decode($this->attributes['norwegian_options']),
        );
    }

    public function shops()
    {
        $cacheKey = 'shops_' . $this->id; 
    
        return Cache::remember($cacheKey, now()->addMinutes(60), function () {
            return $this->belongsToMany(Shop::class, 'language_shop')
                ->withPivot('english', 'spanish', 'norwegian')
                ->withTimestamps()
                ->get();
        });
    }
}
