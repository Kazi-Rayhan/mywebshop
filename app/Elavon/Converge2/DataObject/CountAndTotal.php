<?php

namespace App\Elavon\Converge2\DataObject;

use App\Elavon\Converge2\DataObject\DataGetter\Field\TotalGetterTrait;

final class CountAndTotal extends AbstractDataObject
{
    use TotalGetterTrait;

    protected function castObjectFields()
    {
        $this->castTotal();
    }

    /**
     * @return number|null
     */
    public function getCount()
    {
        return $this->getDataField(C2ApiFieldName::COUNT);
    }
}