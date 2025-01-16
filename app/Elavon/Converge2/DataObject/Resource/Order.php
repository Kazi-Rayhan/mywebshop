<?php

namespace App\Elavon\Converge2\DataObject\Resource;

use App\Elavon\Converge2\DataObject\DataGetter\OrderDataGetterTrait;

class Order extends AbstractResource implements OrderInterface
{
    use OrderDataGetterTrait;
}