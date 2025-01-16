<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = ['city', 'state', 'post_code', 'address', 'shop_id'];

    //Relations

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    public function scopeShop($query, $id)
    {
        return $query->where('shop_id', $id);
    }
}
