<?php

namespace App\Elavon\Converge2\DataObject\DataGetter;

use App\Elavon\Converge2\DataObject\DataGetter\Field\CardGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CreatedAtGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CustomFieldsGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CustomReferenceGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\DeletedAtGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\HostedCardGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\HrefGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\IdGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\MerchantGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ModifiedAtGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ShopperGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\VerificationResultsGetterTrait;

/**
 * @method getDataField($field)
 */
trait StoredCardDataGetterTrait
{
    use IdGetterTrait;
    use HrefGetterTrait;
    use CreatedAtGetterTrait;
    use ModifiedAtGetterTrait;
    use DeletedAtGetterTrait;
    use MerchantGetterTrait;
    use ShopperGetterTrait;
    use HostedCardGetterTrait;
    use CardGetterTrait;
    use VerificationResultsGetterTrait;
    use CustomReferenceGetterTrait;
    use CustomFieldsGetterTrait;

    protected function castObjectFields()
    {
        $this->castCard();
        $this->castVerificationResults();
    }
}
