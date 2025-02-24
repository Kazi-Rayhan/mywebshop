<?php

namespace App\Elavon\Converge2\DataObject\DataGetter;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CardGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ConversionRateGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CreatedAtGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CreatedByGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CustomFieldsGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CustomReferenceGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\DebtorAccountGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\DescriptionGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\FailuresGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\HostedCardGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\HrefGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\IdGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\IssuerTotalGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\MarkupRateAnnotationGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\MarkupRateGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\MerchantGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ModifiedAtGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\OrderGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\OrderReferenceGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ProcessorAccountGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ProcessorReferenceGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ShipToGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ShopperEmailAddressGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ShopperGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ShopperInteractionGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ShopperReferenceGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ShopperStatementGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\StoredCardGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\TotalGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\TotalRefundedGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\VerificationResultsGetterTrait;
use App\Elavon\Converge2\DataObject\DebtorAccount;
use App\Elavon\Converge2\DataObject\RecurringType;
use App\Elavon\Converge2\DataObject\Source;
use App\Elavon\Converge2\DataObject\ThreeDSecureV2;
use App\Elavon\Converge2\DataObject\TransactionState;
use App\Elavon\Converge2\DataObject\TransactionType;

/**
 * @method getDataField($field)
 * @method castToDataObjectClass($field, $class)
 */
trait TransactionDataGetterTrait
{
    use HrefGetterTrait;
    use IdGetterTrait;
    use CreatedAtGetterTrait;
    use ModifiedAtGetterTrait;
    use MerchantGetterTrait;
    use ProcessorAccountGetterTrait;
    use TotalGetterTrait;
    use TotalRefundedGetterTrait;
    use IssuerTotalGetterTrait;
    use ConversionRateGetterTrait;
    use MarkupRateGetterTrait;
    use MarkupRateAnnotationGetterTrait;
    use DescriptionGetterTrait;
    use ShopperStatementGetterTrait;
    use DebtorAccountGetterTrait;
    use CustomReferenceGetterTrait;
    use ShopperReferenceGetterTrait;
    use ProcessorReferenceGetterTrait;
    use OrderReferenceGetterTrait;
    use ShopperInteractionGetterTrait;
    use ShopperGetterTrait;
    use ShipToGetterTrait;
    use ShopperEmailAddressGetterTrait;
    use OrderGetterTrait;
    use CardGetterTrait;
    use HostedCardGetterTrait;
    use StoredCardGetterTrait;
    use CreatedByGetterTrait;
    use CustomFieldsGetterTrait;
    use VerificationResultsGetterTrait;
    use FailuresGetterTrait;

    protected function castObjectFields()
    {
        $this->castType();
        $this->castSource();
        $this->castTotal();
        $this->castTotalRefunded();
        $this->castIssuerTotal();
        $this->castMarkupRateAnnotation();
        $this->castShopperStatement();
        $this->castDebtorAccount();
        $this->castShopperInteraction();
        $this->castShipTo();
        $this->castRecurringType();
        $this->castCard();
        $this->castThreeDSecure();
        $this->castVerificationResults();
        $this->castState();
        $this->castFailures();
    }

    /**
     * @return TransactionType|null
     */
    public function getType()
    {
        return $this->getDataField(C2ApiFieldName::TYPE);
    }

    /**
     * @return Source|null
     */
    public function getSource()
    {
        return $this->getDataField(C2ApiFieldName::SOURCE);
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
    public function getParentTransaction()
    {
        return $this->getDataField(C2ApiFieldName::PARENT_TRANSACTION);
    }

    /**
     * @return string|null
     */
    public function getIssuerReference()
    {
        return $this->getDataField(C2ApiFieldName::ISSUER_REFERENCE);
    }

    /**
     * @return string|null
     */
    public function getShopperIpAddress()
    {
        return $this->getDataField(C2ApiFieldName::SHOPPER_IP_ADDRESS);
    }

    /**
     * @return string|null
     */
    public function getShopperLanguageTag()
    {
        return $this->getDataField(C2ApiFieldName::SHOPPER_LANGUAGE_TAG);
    }

    /**
     * @return string|null
     */
    public function getShopperTimeZone()
    {
        return $this->getDataField(C2ApiFieldName::SHOPPER_TIME_ZONE);
    }

    /**
     * @return string|null
     */
    public function getSubscription()
    {
        return $this->getDataField(C2ApiFieldName::SUBSCRIPTION);
    }

    /**
     * @return RecurringType|null
     */
    public function getRecurringType()
    {
        return $this->getDataField(C2ApiFieldName::RECURRING_TYPE);
    }

    /**
     * @return string|null
     */
    public function getPreviousRecurringTransaction()
    {
        return $this->getDataField(C2ApiFieldName::PREVIOUS_RECURRING_TRANSACTION);
    }

    /**
     * @return string|null
     */
    public function getPaymentLink()
    {
        return $this->getDataField(C2ApiFieldName::PAYMENT_LINK);
    }

    /**
     * @return string|null
     */
    public function getPaymentSession()
    {
        return $this->getDataField(C2ApiFieldName::PAYMENT_SESSION);
    }

    /**
     * @return ThreeDSecureV2|null
     */
    public function getThreeDSecure()
    {
        return $this->getDataField(C2ApiFieldName::THREE_D_SECURE);
    }

    /**
     * @return bool|null
     */
    public function getIsHeldForReview()
    {
        return $this->getDataField(C2ApiFieldName::IS_HELD_FOR_REVIEW);
    }

    /**
     * @return bool|null
     */
    public function getDoCapture()
    {
        return $this->getDataField(C2ApiFieldName::DO_CAPTURE);
    }

    /**
     * @return bool|null
     */
    public function getDoSendReceipt()
    {
        return $this->getDataField(C2ApiFieldName::DO_SEND_RECEIPT);
    }

    /**
     * @return bool|null
     */
    public function getIsAuthorized()
    {
        return $this->getDataField(C2ApiFieldName::IS_AUTHORIZED);
    }

    /**
     * @return string|null
     */
    public function getAuthorizationCode()
    {
        return $this->getDataField(C2ApiFieldName::AUTHORIZATION_CODE);
    }

    /**
     * @return TransactionState|null
     */
    public function getState()
    {
        return $this->getDataField(C2ApiFieldName::STATE);
    }

    /**
     * @return string|null
     */
    public function getBatch()
    {
        return $this->getDataField(C2ApiFieldName::BATCH);
    }

    /**
     * @return array|null
     */
    public function getRelatedTransactions()
    {
        return $this->getDataField(C2ApiFieldName::RELATED_TRANSACTIONS);
    }

    /**
     * @return array|null
     */
    public function getHistory()
    {
        return $this->getDataField(C2ApiFieldName::HISTORY);
    }

    protected function castType()
    {
        $this->castToDataObjectClass(C2ApiFieldName::TYPE, TransactionType::class);
    }

    protected function castSource()
    {
        $this->castToDataObjectClass(C2ApiFieldName::SOURCE, Source::class);
    }

    protected function castDebtorAccount()
    {
        $this->castToDataObjectClass(C2ApiFieldName::DEBTOR_ACCOUNT, DebtorAccount::class);
    }

    protected function castRecurringType()
    {
        $this->castToDataObjectClass(C2ApiFieldName::RECURRING_TYPE, RecurringType::class);
    }

    protected function castThreeDSecure()
    {
        $this->castToDataObjectClass(C2ApiFieldName::THREE_D_SECURE, ThreeDSecureV2::class);
    }

    protected function castState()
    {
        $this->castToDataObjectClass(C2ApiFieldName::STATE, TransactionState::class);
    }
}
