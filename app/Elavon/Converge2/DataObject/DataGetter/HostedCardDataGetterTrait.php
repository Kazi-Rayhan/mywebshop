<?php

namespace App\Elavon\Converge2\DataObject\DataGetter;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CardGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CreatedAtGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CustomFieldsGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\CustomReferenceGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ExpiresAtGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\HrefGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\IdGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\MerchantGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\ModifiedAtGetterTrait;
use App\Elavon\Converge2\DataObject\DataGetter\Field\VerificationResultsGetterTrait;
use App\Elavon\Converge2\DataObject\ThreeDSecureV1;

/** @method getDataField($field) */
trait HostedCardDataGetterTrait
{
    use IdGetterTrait;
    use HrefGetterTrait;
    use CreatedAtGetterTrait;
    use ModifiedAtGetterTrait;
    use ExpiresAtGetterTrait;
    use MerchantGetterTrait;
    use CardGetterTrait;
    use VerificationResultsGetterTrait;
    use CustomReferenceGetterTrait;
    use CustomFieldsGetterTrait;

    protected function castObjectFields()
    {
        $this->castThreeDSecureV1();
        $this->castCard();
        $this->castVerificationResults();
    }

    /**
     * @return ThreeDSecureV1|null
     */
    public function getThreeDSecureV1()
    {
        return $this->getDataField(C2ApiFieldName::THREE_D_SECURE_V1);
    }

    protected function castThreeDSecureV1()
    {
        $three_d_secure_v1 = $this->getThreeDSecureV1();
        if ($three_d_secure_v1) {
            $this->data->{C2ApiFieldName::THREE_D_SECURE_V1} = new ThreeDSecureV1($three_d_secure_v1);
        }
    }

    /**
     * @return bool|null
     */
    public function getDoVerify()
    {
        return $this->getDataField(C2ApiFieldName::DO_VERIFY);
    }
}
