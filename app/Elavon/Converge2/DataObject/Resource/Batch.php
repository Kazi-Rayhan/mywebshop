<?php

namespace App\Elavon\Converge2\DataObject\Resource;

use App\Elavon\Converge2\DataObject\DataGetter\BatchDataGetterTrait;

class Batch extends AbstractResource implements BatchInterface
{
    use BatchDataGetterTrait;
}