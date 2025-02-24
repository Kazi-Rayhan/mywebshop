<?php

namespace App\Elavon\Converge2\Request\Payload\DataSetter;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;

/**
 * @method setField($field, $value)
 */
trait BillCountSetterTrait
{
    public function setBillCount($value)
    {
        $this->setField(C2ApiFieldName::BILL_COUNT, $value);
    }
}
