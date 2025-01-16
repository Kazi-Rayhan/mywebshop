<?php

namespace App\Observers;

use App\Models\Charge;

class ChargeObserver
{
    /**
     * Handle the Charge "created" event.
     *
     * @param  \App\Models\Charge  $charge
     * @return void
     */
    public function created(Charge $charge)
    {
        $charge->is_demo = $charge->shop->is_demo;
        $charge->save();
    }

    /**
     * Handle the Charge "updated" event.
     *
     * @param  \App\Models\Charge  $charge
     * @return void
     */
    public function updated(Charge $charge)
    {
        //
    }

    /**
     * Handle the Charge "deleted" event.
     *
     * @param  \App\Models\Charge  $charge
     * @return void
     */
    public function deleted(Charge $charge)
    {
        //
    }

    /**
     * Handle the Charge "restored" event.
     *
     * @param  \App\Models\Charge  $charge
     * @return void
     */
    public function restored(Charge $charge)
    {
        //
    }

    /**
     * Handle the Charge "force deleted" event.
     *
     * @param  \App\Models\Charge  $charge
     * @return void
     */
    public function forceDeleted(Charge $charge)
    {
        //
    }
}
