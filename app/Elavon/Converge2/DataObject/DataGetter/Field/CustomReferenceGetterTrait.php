<?php

namespace App\Elavon\Converge2\DataObject\DataGetter\Field;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;

/** @method getDataField($field) */
trait CustomReferenceGetterTrait
{
    /**
     * @return string|null
     */
    public function getCustomReference()
    {
        return $this->getDataField(C2ApiFieldName::CUSTOM_REFERENCE);
    }
}