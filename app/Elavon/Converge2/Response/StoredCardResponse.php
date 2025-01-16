<?php

namespace App\Elavon\Converge2\Response;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;
use App\Elavon\Converge2\DataObject\DataGetter\StoredCardDataGetterTrait;

class StoredCardResponse extends Response implements StoredCardResponseInterface
{
    use StoredCardDataGetterTrait;

    /**
     * @return bool
     */
    public function hasFailuresAboutCardAlreadyExists()
    {
        return $this->hasFailuresOnField(C2ApiFieldName::CARD . '.' . C2ApiFieldName::NUMBER);
    }
}
