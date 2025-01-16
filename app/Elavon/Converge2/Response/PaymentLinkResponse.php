<?php

namespace App\Elavon\Converge2\Response;

use App\Elavon\Converge2\DataObject\DataGetter\PaymentLinkDataGetterTrait;

class PaymentLinkResponse extends Response implements PaymentLinkResponseInterface
{
    use PaymentLinkDataGetterTrait;
}
