<?php

namespace App\Elavon\Converge2\DataObject\Resource;

use App\Elavon\Converge2\DataObject\DataGetter\MerchantDataGetterTrait;

class Merchant extends AbstractResource implements MerchantInterface
{
    use MerchantDataGetterTrait;
}