<?php

namespace App\Elavon\Converge2\DataObject\DataGetter\Field;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;

/**
 * @method getDataField($field)
 */
trait MaskedNumberGetterTrait
{
    /**
     * @return string|null
     */
    public function getMaskedNumber()
    {
        return $this->getDataField(C2ApiFieldName::MASKED_NUMBER);
    }
}
