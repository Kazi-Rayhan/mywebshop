<?php

namespace App\Elavon\Converge2\DataObject\DataGetter\Field;

use App\Elavon\Converge2\DataObject\Contact;
use App\Elavon\Converge2\DataObject\C2ApiFieldName;

/**
 * @method getDataField($field)
 * @method castToDataObjectClass($field, $class)
 */
trait BillToGetterTrait
{
    /**
     * @return Contact|null
     */
    public function getBillTo()
    {
        return $this->getDataField(C2ApiFieldName::BILL_TO);
    }

    protected function castBillTo() {
        $this->castToDataObjectClass(C2ApiFieldName::BILL_TO, Contact::class);
    }
}