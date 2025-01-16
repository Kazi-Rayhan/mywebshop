<?php

namespace App\Elavon\Converge2\Request\Payload\DataSetter;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;

trait OrderSetterTrait
{
    public function setOrder($value)
    {
        $this->setField(C2ApiFieldName::ORDER, $value);
    }
}
