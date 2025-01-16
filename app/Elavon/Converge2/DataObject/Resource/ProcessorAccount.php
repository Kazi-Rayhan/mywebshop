<?php

namespace App\Elavon\Converge2\DataObject\Resource;

use App\Elavon\Converge2\DataObject\DataGetter\ProcessorAccountDataGetterTrait;

class ProcessorAccount extends AbstractResource implements ProcessorAccountInterface
{
    use ProcessorAccountDataGetterTrait;
}
