<?php

namespace App\Elavon\Converge2\DataObject\DataGetter;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;
use App\Elavon\Converge2\DataObject\DataGetter\Field\BinGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ConversionRateGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CreatedAtGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CustomFieldsGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CustomReferenceGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ExpiresAtGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\HrefGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\IdGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\IssuerTotalGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\Last4GetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\MarkupRateAnnotationGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\MarkupRateGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\MaskedNumberGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\MerchantGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\PanFingerprintGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ProcessorAccountGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ShopperInteractionGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\StoredCardGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\TotalGetterTrait;

/**
 * @method getDataField($field)
 */
trait ForexAdviceDataGetterTrait
{
    use IdGetterTrait;
    use HrefGetterTrait;
    use CreatedAtGetterTrait;
    use ExpiresAtGetterTrait;
    use MerchantGetterTrait;
    use ProcessorAccountGetterTrait;
    use StoredCardGetterTrait;
    use MaskedNumberGetterTrait;
    use Last4GetterTrait;
    use BinGetterTrait;
    use PanFingerprintGetterTrait;
    use TotalGetterTrait;
    use IssuerTotalGetterTrait;
    use ConversionRateGetterTrait;
    use MarkupRateGetterTrait;
    use MarkupRateAnnotationGetterTrait;
    use ShopperInteractionGetterTrait;
    use CustomReferenceGetterTrait;
    use CustomFieldsGetterTrait;

    protected function castObjectFields()
    {
        $this->castTotal();
        $this->castIssuerTotal();
        $this->castMarkupRateAnnotation();
        $this->castShopperInteraction();
    }

    /**
     * @return string|null
     */
    public function getCardNumber()
    {
        return $this->getDataField(C2ApiFieldName::CARD_NUMBER);
    }
}
