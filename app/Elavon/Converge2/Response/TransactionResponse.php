<?php

namespace App\Elavon\Converge2\Response;

use App\Elavon\Converge2\DataObject\DataGetter\TransactionDataGetterTrait;

class TransactionResponse extends Response implements TransactionResponseInterface
{
    use TransactionDataGetterTrait;
}
