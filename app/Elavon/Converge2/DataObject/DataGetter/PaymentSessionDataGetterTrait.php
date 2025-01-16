<?php

namespace App\Elavon\Converge2\DataObject\DataGetter;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;
use App\Elavon\Converge2\DataObject\DataGetter\Field\BillToGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CreatedAtGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CustomFieldsGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CustomReferenceGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ExpiresAtGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\HostedCardGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\HrefGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\IdGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\MerchantGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ModifiedAtGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\OrderGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ReturnUrlGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ShipToGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ShopperEmailAddressGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ShopperGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\StoredCardGetterTrait;
use App\Elavon\Converge2\DataObject\DebtorAccount;
use App\Elavon\Converge2\DataObject\HppType;
use App\Elavon\Converge2\DataObject\ThreeDSecureV2;

/**
 * @method getDataField($field)
 * @method castToDataObjectClass($field, $class)
 */
trait PaymentSessionDataGetterTrait
{
    use IdGetterTrait;
    use HrefGetterTrait;
    use CreatedAtGetterTrait;
    use ModifiedAtGetterTrait;
    use ExpiresAtGetterTrait;
    use MerchantGetterTrait;
    use OrderGetterTrait;
    use HostedCardGetterTrait;
    use StoredCardGetterTrait;
    use ShopperGetterTrait;
    use ShopperEmailAddressGetterTrait;
    use BillToGetterTrait;
    use ShipToGetterTrait;
    use ReturnUrlGetterTrait;
    use CustomReferenceGetterTrait;
    use CustomFieldsGetterTrait;

    protected function castObjectFields()
    {
        $this->castDebtorAccount();
        $this->castThreeDSecure();
        $this->castBillTo();
        $this->castShipTo();
        $this->castHppType();
    }

    /**
     * @return string|null
     */
    public function getForexAdvice()
    {
        return $this->getDataField(C2ApiFieldName::FOREX_ADVICE);
    }

    /**
     * @return string|null
     */
    public function getTransaction()
    {
        return $this->getDataField(C2ApiFieldName::TRANSACTION);
    }

    /**
     * @return DebtorAccount|null
     */
    public function getDebtorAccount()
    {
        return $this->getDataField(C2ApiFieldName::DEBTOR_ACCOUNT);
    }

    /**
     * @return ThreeDSecureV2|null
     */
    public function getThreeDSecure()
    {
        return $this->getDataField(C2ApiFieldName::THREE_D_SECURE);
    }

    /**
     * @return HppType|null
     */
    public function getHppType()
    {
        return $this->getDataField(C2ApiFieldName::HPP_TYPE);
    }

    /**
     * @return string|null
     */
    public function getCancelUrl()
    {
        return $this->getDataField(C2ApiFieldName::CANCEL_URL);
    }

    /**
     * @return string|null
     */
    public function getOriginUrl()
    {
        return $this->getDataField(C2ApiFieldName::ORIGIN_URL);
    }

    /**
     * @return string|null
     */
    public function getDefaultLanguageTag()
    {
        return $this->getDataField(C2ApiFieldName::DEFAULT_LANGUAGE_TAG);
    }

    /**
     * @return bool|null
     */
    public function getDoCreateTransaction()
    {
        return $this->getDataField(C2ApiFieldName::DO_CREATE_TRANSACTION);
    }

    /**
     * @return bool|null
     */
    public function getDoThreeDSecure()
    {
        return $this->getDataField(C2ApiFieldName::DO_THREE_D_SECURE);
    }

    /**
     * @return string|null
     */
    public function getBlik()
    {
        return $this->getDataField(C2ApiFieldName::BLIK);
    }

    protected function castDebtorAccount()
    {
        $this->castToDataObjectClass(C2ApiFieldName::DEBTOR_ACCOUNT, DebtorAccount::class);
    }

    protected function castThreeDSecure()
    {
        $this->castToDataObjectClass(C2ApiFieldName::THREE_D_SECURE, ThreeDSecureV2::class);
    }

    protected function castHppType()
    {
        $this->castToDataObjectClass(C2ApiFieldName::HPP_TYPE, HppType::class);
    }
}
