<?php

namespace App\Elavon\Converge2\DataObject\DataGetter\Field;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;

/**
 * @method getDataField($field)
 */
trait PostalCodeGetterTrait
{
    /**
     * @return string|null
     */
    public function getPostalCode()
    {
        return $this->getDataField(C2ApiFieldName::POSTAL_CODE);
    }
}
