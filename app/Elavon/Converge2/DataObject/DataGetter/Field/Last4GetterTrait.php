<?php

namespace App\Elavon\Converge2\DataObject\DataGetter\Field;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;

/**
 * @method getDataField($field)
 */
trait Last4GetterTrait
{
    /**
     * @return string|null
     */
    public function getLast4()
    {
        return $this->getDataField(C2ApiFieldName::LAST_4);
    }
}
