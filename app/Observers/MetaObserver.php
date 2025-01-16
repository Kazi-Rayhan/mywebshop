<?php

namespace App\Observers;

use App\Models\Meta;
use Illuminate\Support\Facades\Cache;

class MetaObserver
{
    /**
     * Handle the Meta "created" event.
     *
     * @param  \App\Models\Meta  $meta
     * @return void
     */
    public function created(Meta $meta)
    {
        Cache::put($meta->column_name . '_' . $meta->metable_type . '_' . $meta->metable_id, $meta->column_value, 10000);
    }

    /**
     * Handle the Meta "updated" event.
     *
     * @param  \App\Models\Meta  $meta
     * @return void
     */
    public function updated(Meta $meta)
    {
        Cache::put($meta->column_name . '_' . $meta->metable_type . '_' . $meta->metable_id, $meta->column_value, 10000);
    }

    /**
     * Handle the Meta "deleted" event.
     *
     * @param  \App\Models\Meta  $meta
     * @return void
     */
    public function deleted(Meta $meta)
    {
        //
    }

    /**
     * Handle the Meta "restored" event.
     *
     * @param  \App\Models\Meta  $meta
     * @return void
     */
    public function restored(Meta $meta)
    {
        //
    }

    /**
     * Handle the Meta "force deleted" event.
     *
     * @param  \App\Models\Meta  $meta
     * @return void
     */
    public function forceDeleted(Meta $meta)
    {
        //
    }
}
