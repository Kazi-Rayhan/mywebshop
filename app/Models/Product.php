<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attribute as AttributeModel;
use App\Models\Traits\checkOwner;
use Iziibuy;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }


    public function images(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => json_decode($value) ?? [],
            set: fn (array $value = []) => json_encode($value)
        );
    }

    public function quantity(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value > 0 ? $value : 0
        );
    }


    public function areas(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (array)  json_decode($value),
            set: fn ($value) => json_encode($value ?? [])
        );
    }



    public function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['price'] / 100,
            set: fn ($value) => $value * 100,
        );
    }
    public function saleprice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['saleprice'] / 100,
            set: fn ($value) => $value * 100,
        );
    }

    public function retailerprice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['retailerprice'] / 100,
            set: fn ($value) => $value * 100,
        );
    }

    public function retailersaleprice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->attributes['retailersaleprice'] / 100,
            set: fn ($value) => $value * 100,
        );
    }




    public function calculatedprice(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->parent_id) {
                    return $this->attributes['price'];
                } else {

                    $shop_has_area = $this->shop->hasArea();
                    $shop_has_retailer_pricing = $this->shop->hasRetailerPricing();
                    if ($shop_has_retailer_pricing) {
                        return $this->attributes['retailerprice'] / 100;
                    }
                    if ($shop_has_area && $this->area) {
                        return $this->areas[$this->shop->area->key]->price;
                    }
                    return $this->attributes['price'] / 100;
                }
            },
        );
    }
    public function calculatedsaleprice(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->parent_id) {
                    return $this->attributes['saleprice'];
                } else {
                    $shop_has_area = $this->shop->hasArea();
                    $shop_has_retailer_pricing = $this->shop->hasRetailerPricing();
                    if ($shop_has_retailer_pricing) {
                        return null;
                    }
                    if ($shop_has_area) {
                        if ($this->area && $this->areas[$this->shop->area_id]->saleprice > 0) {
                            return $this->areas[$this->shop->area->key]?->saleprice;
                        };
                    }
                    return $this->attributes['saleprice'] / 100;
                }
            },
        );
    }
    public function previousPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => !empty($this->calculatedsaleprice) ? $this->calculatedprice : 0
        );
    }
    public function currentPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => !empty($this->calculatedsaleprice) ? $this->calculatedsaleprice : $this->calculatedprice
        );
    }
    public function originalPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Iziibuy::round_num($this->currentPrice / (1 + ($this->attributes['tax']) / 100))
        );
    }

    public function taxAmount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Iziibuy::round_num($this->currentPrice  - $this->originalPrice)
        );
    }


    // Start of Relations
    public function attributes()
    {
        return $this->hasMany(AttributeModel::class);
    }

    public function subproducts()
    {
        return $this->hasMany(Product::class, 'parent_id', 'id');
    }


    public function stores()
    {
        return $this->belongsToMany(Store::class)->withPivot('quantity');
    }


    public function sub_categories()
    {
        return $this->belongsToMany(Category::class)->whereNotNull('parent_id')->withTimestamps();
    }

    public function sub_sub_categories()
    {
        return $this->belongsToMany(Category::class)->whereIn('parent_id', $this->sub_categories->pluck('id'))->withTimestamps();
    }

    public function parent_categories()
    {
        return $this->belongsToMany(Category::class)->whereNull('parent_id')->withTimestamps();
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function variations()
    {
        return $this->hasMany(Product::class, 'parent_id', 'id')->where('price', '>', 0)->whereNotNull('variation');
    }
    //End of Relations

    //Start of helpers
    public function path()
    {
        return route('product', [$this->shop->user_name, $this->slug]);
    }
    //End of helpers

    public function ratings()
    {
        return $this->hasMany(Rating::class)->where('status', 1)->latest();
    }


    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }


    public function subproductsuser()
    {
        return $this->hasMany(Product::class, 'parent_id', 'id')->where('price', '>', 0)->whereNotNull('variation');
    }


    public function setVariationAttribute($value)
    {
        $this->attributes['variation'] = json_encode($value);
    }


    public function scopePublished($query)
    {
        return $query->whereNull('parent_id')->where('status', 1);
    }

    public function scopeOwnedByThisShop($query, Shop $shop)
    {
        return $query->whereHas('shop', function ($query) use ($shop) {

            if (env('enterprise')) {
                return  $query->where('user_name', env('default_username') ?? $shop->user_name);
            } else {
                return $query->where('id', $shop->id);
            }
        });
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }
}
