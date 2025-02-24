<?php

namespace App\Elavon\Converge2\Request\Payload\DataSetter;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;

trait ShipToSetterTrait
{
    public function setShipTo($value)
    {
        $this->setField(C2ApiFieldName::SHIP_TO, $value);
    }
}
