<?php

namespace App\Elavon\Converge2\Response;

use App\Elavon\Converge2\DataObject\DataGetter\PlanDataGetterTrait;

class PlanResponse extends Response implements PlanResponseInterface
{
    use PlanDataGetterTrait;
}
