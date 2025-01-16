<?php

namespace App\Elavon\Converge2\DataObject\Resource;

use App\Elavon\Converge2\DataObject\DataGetter\SubscriptionDataGetterTrait;

class Subscription extends AbstractResource implements SubscriptionInterface
{
    use SubscriptionDataGetterTrait;
}
