<?php

namespace App\Elavon\Converge2\Response;

use App\Elavon\Converge2\DataObject\DataGetter\PaymentSessionDataGetterTrait;

class PaymentSessionResponse extends Response implements PaymentSessionResponseInterface
{
    use PaymentSessionDataGetterTrait;
}
