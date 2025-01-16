<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Iziibuy;

class Service extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function resource()
    {
        return $this->belongsTo(Resource::class)->withDefault();
    }

    /**
     * Get the group price for the service.
     */
    public function groupPricing()
    {
        return $this->hasMany(PriceGroup::class, 'service_id');
    }

    /**
     * The store that belong to the service.
     */
    public function stores()
    {
        return $this->belongsToMany(Store::class)
            ->withTimestamps();
    }

    /**
     * The manager that belong to the service.
     */
    public function managers()
    {
        return $this->belongsToMany(User::class, 'service_user', 'service_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * get price group for specific group
     *
     * @param string $groupName
     * @return \App\Models\PriceGroup
     */
    public function getParentPriceGroup($parent)
    {
        $priceGroup = $this->groupPricing->where('parent_id', $parent)->first();

        if ($priceGroup) {
            return $priceGroup;
        };

        return new PriceGroup();
    }

    public function price(User $manager)
    {
        $userPriceGroup = $manager->priceGroups()
            ->where('service_id', $this->id)
            ->value('price_group_id');

        $price = $this->groupPricing()
            ->where('parent_id', $userPriceGroup)
            ->value('price');

        return $price;
    }

    public function priceFormated(User $manager)
    {
        $userPriceGroup = $manager->priceGroups()
            ->where('service_id', $this->id)
            ->value('price_group_id');

        $price = $this->groupPricing()
            ->where('parent_id', $userPriceGroup)
            ->value('price');

        return Iziibuy::price($price);
    }
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function isActive()
    {
        return $this->status === 1;
    }
}
