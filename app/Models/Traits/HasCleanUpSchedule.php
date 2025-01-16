<?php

namespace App\Models\Traits;

trait HasCleanUpSchedule
{
    public static function bootHasCleanUpSchedule()
    {
        static::deleting(function ($model) {
            $model->schedules()->delete();
        });
    }
}
