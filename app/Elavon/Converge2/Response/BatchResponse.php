<?php

namespace App\Elavon\Converge2\Response;

use App\Elavon\Converge2\DataObject\DataGetter\BatchDataGetterTrait;

class BatchResponse extends Response implements BatchResponseInterface
{
    use BatchDataGetterTrait;
}
