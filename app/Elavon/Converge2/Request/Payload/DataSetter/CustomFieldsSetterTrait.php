<?php

namespace App\Elavon\Converge2\Request\Payload\DataSetter;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;

trait CustomFieldsSetterTrait
{
    public function setCustomFields($value)
    {
        $this->setField(C2ApiFieldName::CUSTOM_FIELDS, $value);
    }
}
