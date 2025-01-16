<?php

namespace App\Elavon\Converge2\Request\Payload;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;
use App\Elavon\Converge2\Request\Payload\DataSetter\DescriptionSetterTrait;
use App\Elavon\Converge2\Request\Payload\DataSetter\TotalSetterTrait;
use App\Elavon\Converge2\Request\Payload\DataSetter\BillCountSetterTrait;
use App\Elavon\Converge2\Request\Payload\DataSetter\ShopperStatementSetterTrait;
use App\Elavon\Converge2\Request\Payload\DataSetter\CustomReferenceSetterTrait;
use App\Elavon\Converge2\Request\Payload\DataSetter\CustomFieldsSetterTrait;

class PlanDataBuilder extends AbstractDataBuilder
{
    use DescriptionSetterTrait;
    use TotalSetterTrait;
    use BillCountSetterTrait;
    use ShopperStatementSetterTrait;
    use CustomReferenceSetterTrait;
    use CustomFieldsSetterTrait;

    public function setName($value)
    {
        $this->setField(C2ApiFieldName::NAME, $value);
    }

    public function setBillingInterval($value)
    {
        $this->setField(C2ApiFieldName::BILLING_INTERVAL, $value);
    }

    public function setInitialTotal($value)
    {
        $this->setField(C2ApiFieldName::INITIAL_TOTAL, $value);
    }

    public function setInitialTotalBillCount($value)
    {
        $this->setField(C2ApiFieldName::INITIAL_TOTAL_BILL_COUNT, $value);
    }

    public function setIsSubscribable($value)
    {
        $this->setField(C2ApiFieldName::IS_SUBSCRIBABLE, $value);
    }
}
