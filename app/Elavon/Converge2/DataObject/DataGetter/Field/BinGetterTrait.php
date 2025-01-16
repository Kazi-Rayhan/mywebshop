<?php

namespace App\Elavon\Converge2\DataObject\DataGetter\Field;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;

/**
 * @method getDataField($field)
 */
trait BinGetterTrait
{
    /**
     * @return string|null
     */
    public function getBin()
    {
        return $this->getDataField(C2ApiFieldName::BIN);
    }
}
