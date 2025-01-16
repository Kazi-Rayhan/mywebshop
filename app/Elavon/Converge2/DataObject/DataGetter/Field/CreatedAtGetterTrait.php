<?php

namespace App\Elavon\Converge2\DataObject\DataGetter\Field;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;

/** @method getDataField($field) */
trait CreatedAtGetterTrait
{
    /**
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->getDataField(C2ApiFieldName::CREATED_AT);
    }
}