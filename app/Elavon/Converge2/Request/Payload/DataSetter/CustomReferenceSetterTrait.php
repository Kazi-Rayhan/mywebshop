<?php

namespace App\Elavon\Converge2\Request\Payload\DataSetter;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;

trait CustomReferenceSetterTrait
{
    public function setCustomReference($value)
    {
        $this->setField(C2ApiFieldName::CUSTOM_REFERENCE, $value);
    }
}
