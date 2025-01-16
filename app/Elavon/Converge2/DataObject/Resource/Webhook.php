<?php

namespace App\Elavon\Converge2\DataObject\Resource;

use App\Elavon\Converge2\DataObject\DataGetter\WebhookDataGetterTrait;

class Webhook extends AbstractResource implements WebhookInterface
{
    use WebhookDataGetterTrait;
}
