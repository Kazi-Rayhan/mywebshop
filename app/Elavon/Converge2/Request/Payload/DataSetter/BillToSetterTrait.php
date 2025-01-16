<?php

namespace App\Elavon\Converge2\Request\Payload\DataSetter;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;

/**
 * @method setField($field, $value)
 */
trait BillToSetterTrait
{
    public function setBillTo($value)
    {
        $this->setField(C2ApiFieldName::BILL_TO, $value);
    }
}
