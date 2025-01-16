<?php

namespace App\Elavon\Converge2\Response;

use App\Elavon\Converge2\DataObject\DataGetter\ShopperDataGetterTrait;

class ShopperResponse extends Response implements ShopperResponseInterface
{
    use ShopperDataGetterTrait;
}
