<?php

namespace App\Elavon\Converge2\Response;

use App\Elavon\Converge2\DataObject\DataGetter\ProcessorAccountDataGetterTrait;

class ProcessorAccountResponse extends Response implements ProcessorAccountResponseInterface
{
    use ProcessorAccountDataGetterTrait;
}
