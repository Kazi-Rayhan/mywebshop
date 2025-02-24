<?php

namespace App\Elavon\Converge2\DataObject\DataGetter\Field;

use App\Elavon\Converge2\DataObject\Contact;
use App\Elavon\Converge2\DataObject\C2ApiFieldName;

/**
 * @method getDataField($field)
 * @method castToDataObjectClass($field, $class)
 */
trait ShipToGetterTrait
{
    /**
     * @return Contact|null
     */
    public function getShipTo()
    {
        return $this->getDataField(C2ApiFieldName::SHIP_TO);
    }

    protected function castShipTo()
    {
        $this->castToDataObjectClass(C2ApiFieldName::SHIP_TO, Contact::class);
    }
}