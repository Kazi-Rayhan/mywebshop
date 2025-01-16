<?php

namespace App\Elavon\Converge2\Request\Payload\DataSetter;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;

/**
 * @method setField($field, $value)
 */
trait DebtorAccountSetterTrait
{
    public function setDebtorAccount($value)
    {
        $this->setField(C2ApiFieldName::DEBTOR_ACCOUNT, $value);
    }
}
