<?php

namespace App\Elavon\Converge2\DataObject\DataGetter;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CreatedAtGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CustomFieldsGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CustomReferenceGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\DescriptionGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\HrefGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\IdGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\MerchantGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ModifiedAtGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\OrderReferenceGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ShipToGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ShopperEmailAddressGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ShopperReferenceGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\TotalGetterTrait;
use App\Elavon\Converge2\DataObject\OrderItem;

/**
 * @method getDataField($field)
 * @method castToDataObjectClass($field, $class)
 */
trait OrderDataGetterTrait
{
    use IdGetterTrait;
    use HrefGetterTrait;
    use CreatedAtGetterTrait;
    use ModifiedAtGetterTrait;
    use MerchantGetterTrait;
    use TotalGetterTrait;
    use DescriptionGetterTrait;
    use ShipToGetterTrait;
    use ShopperEmailAddressGetterTrait;
    use ShopperReferenceGetterTrait;
    use OrderReferenceGetterTrait;
    use CustomReferenceGetterTrait;
    use CustomFieldsGetterTrait;

    protected function castObjectFields()
    {
        $this->castTotal();
        $this->castItems();
        $this->castShipTo();
    }

    /**
     * @return array|null
     */
    public function getItems()
    {
        return $this->getDataField(C2ApiFieldName::ITEMS);
    }

    protected function castItems()
    {
        $this->castToDataObjectClass(C2ApiFieldName::ITEMS, OrderItem::class);
    }
}
