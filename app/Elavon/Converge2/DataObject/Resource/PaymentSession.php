<?php

namespace App\Elavon\Converge2\DataObject\Resource;

use App\Elavon\Converge2\DataObject\DataGetter\PaymentSessionDataGetterTrait;

class PaymentSession extends AbstractResource implements PaymentSessionInterface
{
    use PaymentSessionDataGetterTrait;
}
