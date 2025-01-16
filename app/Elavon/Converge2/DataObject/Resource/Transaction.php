<?php

namespace App\Elavon\Converge2\DataObject\Resource;

use App\Elavon\Converge2\DataObject\DataGetter\TransactionDataGetterTrait;

class Transaction extends AbstractResource implements TransactionInterface
{
    use TransactionDataGetterTrait;
}
