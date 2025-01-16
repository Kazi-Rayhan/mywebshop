<?php

namespace App\Elavon\Converge2\DataObject\DataGetter;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CreatedAtGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CustomFieldsGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CustomReferenceGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\DescriptionGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ExpiresAtGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\HrefGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\IdGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\MerchantGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ModifiedAtGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\OrderReferenceGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ReturnUrlGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ShopperEmailAddressGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\TotalGetterTrait;
use App\Elavon\Converge2\DataObject\DebtorAccount;

/**
 * @method getDataField($field)
 * @method castToDataObjectClass($field, $class)
 */
trait PaymentLinkDataGetterTrait
{
    use IdGetterTrait;
    use HrefGetterTrait;
    use CreatedAtGetterTrait;
    use ModifiedAtGetterTrait;
    use ExpiresAtGetterTrait;
    use MerchantGetterTrait;
    use ReturnUrlGetterTrait;
    use DescriptionGetterTrait;
    use TotalGetterTrait;
    use OrderReferenceGetterTrait;
    use ShopperEmailAddressGetterTrait;
    use CustomReferenceGetterTrait;
    use CustomFieldsGetterTrait;

    protected function castObjectFields()
    {
        $this->castTotal();
        $this->castDebtorAccount();
    }

    /**
     * @return string|null
     */
    public function getCancelledAt()
    {
        return $this->getDataField(C2ApiFieldName::CANCELLED_AT);
    }

    /**
     * @return bool|null
     */
    public function getDoCancel()
    {
        return $this->getDataField(C2ApiFieldName::DO_CANCEL);
    }

    /**
     * @return string|null
     */
    public function getUrl()
    {
        return $this->getDataField(C2ApiFieldName::URL);
    }

    /**
     * @return number|null
     */
    public function getConversionLimit()
    {
        return $this->getDataField(C2ApiFieldName::CONVERSION_LIMIT);
    }

    /**
     * @return number|null
     */
    public function getConversionCount()
    {
        return $this->getDataField(C2ApiFieldName::CONVERSION_COUNT);
    }

    /**
     * @return number|null
     */
    public function getClickCount()
    {
        return $this->getDataField(C2ApiFieldName::CLICK_COUNT);
    }

    /**
     * @return DebtorAccount|null
     */
    public function getDebtorAccount()
    {
        return $this->getDataField(C2ApiFieldName::DEBTOR_ACCOUNT);
    }

    protected function castDebtorAccount()
    {
        $this->castToDataObjectClass(C2ApiFieldName::DEBTOR_ACCOUNT, DebtorAccount::class);
    }
}
