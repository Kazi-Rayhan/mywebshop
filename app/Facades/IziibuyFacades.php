<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class IziibuyFacades extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'iziibuy';
    }
}
