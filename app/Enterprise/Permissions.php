<?php

namespace App\Enterprise;

use App\Models\Enterprise;
use Illuminate\Support\Facades\Cache;

class Permissions
{
    public static function check($FEATURE, $ACTION)
    {
        
        $permissions = Cache::remember('permissions', 300, function () {
            return  Enterprise::firstOrNew()->permissions;
        });

        if (!array_key_exists($FEATURE, $permissions)) return false;

        if (!array_key_exists($ACTION, $permissions[$FEATURE])) return false;

        return $permissions[$FEATURE][$ACTION];
    }
}
