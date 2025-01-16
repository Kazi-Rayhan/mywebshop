<?php

namespace App\Elavon\Converge2\Request\Payload;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;
use App\Elavon\Converge2\Request\Payload\DataSetter\CustomFieldsSetterTrait;
use App\Elavon\Converge2\Request\Payload\DataSetter\CustomReferenceSetterTrait;
use App\Elavon\Converge2\Request\Payload\DataSetter\DescriptionSetterTrait;
use App\Elavon\Converge2\Request\Payload\DataSetter\OrderReferenceSetterTrait;
use App\Elavon\Converge2\Request\Payload\DataSetter\ShipToSetterTrait;
use App\Elavon\Converge2\Request\Payload\DataSetter\ShopperEmailAddressSetterTrait;
use App\Elavon\Converge2\Request\Payload\DataSetter\ShopperReferenceSetterTrait;
use App\Elavon\Converge2\Request\Payload\DataSetter\TotalSetterTrait;

class OrderDataBuilder extends AbstractDataBuilder
{
    use TotalSetterTrait;
    use DescriptionSetterTrait;
    use ShipToSetterTrait;
    use ShopperEmailAddressSetterTrait;
    use ShopperReferenceSetterTrait;
    use CustomReferenceSetterTrait;
    use CustomFieldsSetterTrait;
    use OrderReferenceSetterTrait;

    public function setItems($value)
    {
        $this->setField(C2ApiFieldName::ITEMS, $value);
    }
}
