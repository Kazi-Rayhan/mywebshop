<?php

namespace App\Elavon\Converge2\Response;

use App\Elavon\Converge2\DataObject\DataGetter\MerchantDataGetterTrait;

class MerchantResponse extends Response implements MerchantResponseInterface
{
    use MerchantDataGetterTrait;
}
