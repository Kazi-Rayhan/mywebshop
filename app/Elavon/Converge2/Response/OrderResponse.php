<?php

namespace App\Elavon\Converge2\Response;

use App\Elavon\Converge2\DataObject\DataGetter\OrderDataGetterTrait;

class OrderResponse extends Response implements OrderResponseInterface
{
    use OrderDataGetterTrait;
}
