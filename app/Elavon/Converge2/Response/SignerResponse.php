<?php

namespace App\Elavon\Converge2\Response;

use App\Elavon\Converge2\DataObject\DataGetter\SignerDataGetterTrait;

class SignerResponse extends Response implements SignerResponseInterface
{
    use SignerDataGetterTrait;
}
