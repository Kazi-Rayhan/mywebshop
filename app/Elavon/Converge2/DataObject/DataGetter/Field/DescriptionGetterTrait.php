<?php

namespace App\Elavon\Converge2\DataObject\DataGetter\Field;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;

/** @method getDataField($field) */
trait DescriptionGetterTrait
{
    /**
     * @return string|null
     */
    public function getDescription()
    {
        return $this->getDataField(C2ApiFieldName::DESCRIPTION);
    }
}