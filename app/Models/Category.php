<?php

namespace App\Models;

use App\Models\Traits\checkOwner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected  $with = ['childrens'];
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    public function productsActive()
    {
        return $this->belongsToMany(Product::class)->where('status', 1);
    }

    public function childrens()
    {
        return $this->hasMany(Category::class, 'parent_id')->has('products')->with('childrens', function ($query) {
            $query->has('products');
        })->orderBy('name');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    
    public function scopeOwnedByThisShop($query, Shop $shop)
    {
        return $query->whereHas('shop', function ($query) use ($shop) {
            if (env('enterprise')) {
                return  $query->where('user_name', env('default_username'));
            } else {
                return $query->where('id', $shop->id);
            }
        });
    }
}
