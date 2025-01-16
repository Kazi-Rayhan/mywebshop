<?php

namespace App\Observers;

use App\Models\Shop;
use App\Services\RetailerCommission;

class ShopObserver
{
    /**
     * Handle the Shop "created" event.
     *
     * @param  \App\Models\Shop  $shop
     * @return void
     */
    public function created(Shop $shop)
    {
        //
    }

    /**
     * Handle the Shop "updated" event.
     *
     * @param  \App\Models\Shop  $shop
     * @return void
     */
    public function updated(Shop $shop)
    {


        
        if ($shop->isDirty('retailer_id') == true) {
            $newShop = Shop::find($shop->id);
            $newShop->previous_retailer = $shop->getOriginal('retailer_id');
            if ($shop->isDirty('retailer_joined_at') == false) {
                if ($shop->retailer_joined_at == null) $newShop->retailer_joined_at = now();
            }
            $newShop->save();      
            RetailerCommission::pending_commissions($newShop)->pay();
            
        }

        // If the is_demo attribute of the shop is updated
        if ($shop->isDirty('is_demo')) {
            $shop->charges()->update(['is_demo' => $shop->is_demo]);
        }
    }

    /**
     * Handle the Shop "deleted" event.
     *
     * @param  \App\Models\Shop  $shop
     * @return void
     */
    public function deleted(Shop $shop)
    {
        $shop->user()->delete();
        $shop->stores()->delete();
        $shop->levels()->delete();
        $shop->products()->delete();
        $shop->coupons()->delete();
        $shop->options()->delete();
        $shop->packages()->delete();
        $shop->shippings()->delete();
        $shop->priceGroups()->delete();
        $shop->bookings()->delete();
        $shop->area()->delete();
    }

    /**
     * Handle the Shop "restored" event.
     *
     * @param  \App\Models\Shop  $shop
     * @return void
     */
    public function restored(Shop $shop)
    {
        //
    }

    /**
     * Handle the Shop "force deleted" event.
     *
     * @param  \App\Models\Shop  $shop
     * @return void
     */
    public function forceDeleted(Shop $shop)
    {
        //
    }
}
