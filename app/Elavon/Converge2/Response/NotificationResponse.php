<?php

namespace App\Elavon\Converge2\Response;

use App\Elavon\Converge2\DataObject\DataGetter\NotificationDataGetterTrait;

class NotificationResponse extends Response implements NotificationResponseInterface
{
    use NotificationDataGetterTrait;
}
