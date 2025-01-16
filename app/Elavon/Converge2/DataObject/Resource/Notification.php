<?php

namespace App\Elavon\Converge2\DataObject\Resource;

use App\Elavon\Converge2\DataObject\DataGetter\NotificationDataGetterTrait;

class Notification extends AbstractResource implements NotificationInterface
{
    use NotificationDataGetterTrait;
}
