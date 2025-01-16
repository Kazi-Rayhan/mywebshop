<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\Translatable;

class Packageoption extends Model
{
    use HasFactory, Translatable;

    protected $translatable = ['title', 'details'];

    protected $fillable = [
        'title',
        'buffer',
        'details',
        'minutes',
        'shop_id',
    ];

    protected $casts = [
        'buffer' => 'integer',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function getDefaultAttribute()
    {
        if (isset($this->shop) && $this->shop->defaultoption->id == $this->id) {
            return true;
        }

        return false;
    }

    
    public function priceFormated()
    {
        return $this->minutes . ' Minutes';
    }
    public function price()
    {
        return $this->minutes;
    }
}
