<?php

namespace App\Elavon\Converge2\DataObject\DataGetter\Field;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;

/**
 * @method getDataField($field)
 */
trait MarkupRateGetterTrait
{
    /**
     * @return string|null
     */
    public function getMarkupRate()
    {
        return $this->getDataField(C2ApiFieldName::MARKUP_RATE);
    }
}
