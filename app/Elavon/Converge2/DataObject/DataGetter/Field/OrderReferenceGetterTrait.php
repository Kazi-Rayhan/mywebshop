<?php

namespace App\Elavon\Converge2\DataObject\DataGetter\Field;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;

/**
 * @method getDataField($field)
 */
trait OrderReferenceGetterTrait
{
    /**
     * @return string|null
     */
    public function getOrderReference()
    {
        return $this->getDataField(C2ApiFieldName::ORDER_REFERENCE);
    }
}