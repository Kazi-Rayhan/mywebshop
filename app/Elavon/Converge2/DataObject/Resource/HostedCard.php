<?php

namespace App\Elavon\Converge2\DataObject\Resource;

use App\Elavon\Converge2\DataObject\DataGetter\HostedCardDataGetterTrait;

class HostedCard extends AbstractResource implements HostedCardInterface
{
    use HostedCardDataGetterTrait;
}