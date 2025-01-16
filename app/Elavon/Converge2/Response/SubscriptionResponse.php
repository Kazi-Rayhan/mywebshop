<?php

namespace App\Elavon\Converge2\Response;

use App\Elavon\Converge2\DataObject\DataGetter\SubscriptionDataGetterTrait;

class SubscriptionResponse extends Response implements SubscriptionResponseInterface
{
    use SubscriptionDataGetterTrait;
}
