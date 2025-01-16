<?php

namespace App\Elavon\Converge2\DataObject\Resource;

use App\Elavon\Converge2\DataObject\DataGetter\PaymentLinkDataGetterTrait;

class PaymentLink extends AbstractResource implements PaymentLinkInterface
{
    use PaymentLinkDataGetterTrait;
}
