<?php

namespace App\Elavon\Converge2\Request\Payload\DataSetter;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;

/**
 * @method setField($field, $value)
 */
trait PostalCodeSetterTrait
{
    public function setPostalCode($value)
    {
        $this->setField(C2ApiFieldName::POSTAL_CODE, $value);
    }
}
