<?php

namespace App\Elavon\Converge2\Request\Payload\DataSetter;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;

trait ShopperEmailAddressSetterTrait
{
    public function setShopperEmailAddress($value)
    {
        $this->setField(C2ApiFieldName::SHOPPER_EMAIL_ADDRESS, $value);
    }
}
