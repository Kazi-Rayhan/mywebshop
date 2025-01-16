<?php

namespace App\Elavon\Converge2\DataObject\DataGetter;

use App\Elavon\Converge2\DataObject\BillingInterval;
use App\Elavon\Converge2\DataObject\C2ApiFieldName;
use App\Elavon\Converge2\DataObject\DataGetter\Field\BillCountGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CreatedAtGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CustomFieldsGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CustomReferenceGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\DeletedAtGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\DescriptionGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\HrefGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\IdGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\InitialTotalGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\MerchantGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ModifiedAtGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ShopperStatementGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\TotalGetterTrait;

/**
 * @method getDataField($field)
 * @method castToDataObjectClass($field, $class)
 */
trait PlanDataGetterTrait
{
    use IdGetterTrait;
    use HrefGetterTrait;
    use CreatedAtGetterTrait;
    use ModifiedAtGetterTrait;
    use DeletedAtGetterTrait;
    use MerchantGetterTrait;
    use DescriptionGetterTrait;
    use TotalGetterTrait;
    use BillCountGetterTrait;
    use InitialTotalGetterTrait;
    use ShopperStatementGetterTrait;
    use CustomReferenceGetterTrait;
    use CustomFieldsGetterTrait;

    protected function castObjectFields()
    {
        $this->castBillingInterval();
        $this->castTotal();
        $this->castInitialTotal();
        $this->castShopperStatement();
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->getDataField(C2ApiFieldName::NAME);
    }

    /**
     * @return BillingInterval|null
     */
    public function getBillingInterval()
    {
        return $this->getDataField(C2ApiFieldName::BILLING_INTERVAL);
    }

    /**
     * @return number|null
     */
    public function getInitialTotalBillCount()
    {
        return $this->getDataField(C2ApiFieldName::INITIAL_TOTAL_BILL_COUNT);
    }

    /**
     * @return bool|null
     */
    public function getIsSubscribable()
    {
        return $this->getDataField(C2ApiFieldName::IS_SUBSCRIBABLE);
    }

    protected function castBillingInterval()
    {
        $this->castToDataObjectClass(C2ApiFieldName::BILLING_INTERVAL, BillingInterval::class);
    }
}
