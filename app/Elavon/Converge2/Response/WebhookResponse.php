<?php

namespace App\Elavon\Converge2\Response;

use App\Elavon\Converge2\DataObject\DataGetter\WebhookDataGetterTrait;

class WebhookResponse extends Response implements WebhookResponseInterface
{
    use WebhookDataGetterTrait;
}
