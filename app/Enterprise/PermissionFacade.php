<?php

namespace App\Enterprise;

use Illuminate\Support\Facades\Facade;

class PermissionFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'permission';
    }
}
