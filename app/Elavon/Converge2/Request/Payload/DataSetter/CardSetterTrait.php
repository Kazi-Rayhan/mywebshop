<?php

namespace App\Elavon\Converge2\Request\Payload\DataSetter;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;

/**
 * @method setField($field, $value)
 */
trait CardSetterTrait
{
    public function setCard($value)
    {
        $this->setField(C2ApiFieldName::CARD, $value);
    }
}
