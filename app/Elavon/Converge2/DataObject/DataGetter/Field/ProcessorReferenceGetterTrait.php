<?php

namespace App\Elavon\Converge2\DataObject\DataGetter\Field;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;

/** @method getDataField($field) */
trait ProcessorReferenceGetterTrait
{
    /**
     * @return string|null
     */
    public function getProcessorReference()
    {
        return $this->getDataField(C2ApiFieldName::PROCESSOR_REFERENCE);
    }
}