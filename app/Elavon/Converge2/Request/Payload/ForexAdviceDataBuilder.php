<?php

namespace App\Elavon\Converge2\Request\Payload;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;
use App\Elavon\Converge2\Request\Payload\DataSetter\CustomFieldsSetterTrait;
use App\Elavon\Converge2\Request\Payload\DataSetter\CustomReferenceSetterTrait;
use App\Elavon\Converge2\Request\Payload\DataSetter\ShopperInteractionSetterTrait;
use App\Elavon\Converge2\Request\Payload\DataSetter\StoredCardSetterTrait;
use App\Elavon\Converge2\Request\Payload\DataSetter\TotalSetterTrait;

class ForexAdviceDataBuilder extends AbstractDataBuilder
{
    use StoredCardSetterTrait;
    use TotalSetterTrait;
    use ShopperInteractionSetterTrait;
    use CustomReferenceSetterTrait;
    use CustomFieldsSetterTrait;

    public function setProcessorAccount($value)
    {
        $this->setField(C2ApiFieldName::PROCESSOR_ACCOUNT, $value);
    }

    public function setCardNumber($value)
    {
        $this->setField(C2ApiFieldName::CARD_NUMBER, $value);
    }
}
