<?php

namespace App\Elavon\Converge2\Response;

use App\Elavon\Converge2\DataObject\DataGetter\ForexAdviceDataGetterTrait;

class ForexAdviceResponse extends Response implements ForexAdviceResponseInterface
{
    use ForexAdviceDataGetterTrait;
}
