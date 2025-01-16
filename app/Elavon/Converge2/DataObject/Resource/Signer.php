<?php

namespace App\Elavon\Converge2\DataObject\Resource;

use App\Elavon\Converge2\DataObject\DataGetter\SignerDataGetterTrait;

class Signer extends AbstractResource implements SignerInterface
{
    use SignerDataGetterTrait;
}
