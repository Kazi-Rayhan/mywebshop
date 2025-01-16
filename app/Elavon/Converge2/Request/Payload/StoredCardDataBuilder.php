<?php

namespace App\Elavon\Converge2\Request\Payload;

use App\Elavon\Converge2\Request\Payload\DataSetter\ShopperSetterTrait;
use App\Elavon\Converge2\Request\Payload\DataSetter\HostedCardSetterTrait;
use App\Elavon\Converge2\Request\Payload\DataSetter\CardSetterTrait;
use App\Elavon\Converge2\Request\Payload\DataSetter\CustomReferenceSetterTrait;
use App\Elavon\Converge2\Request\Payload\DataSetter\CustomFieldsSetterTrait;

class StoredCardDataBuilder extends AbstractDataBuilder
{
    use ShopperSetterTrait;
    use HostedCardSetterTrait;
    use CardSetterTrait;
    use CustomReferenceSetterTrait;
    use CustomFieldsSetterTrait;
}
