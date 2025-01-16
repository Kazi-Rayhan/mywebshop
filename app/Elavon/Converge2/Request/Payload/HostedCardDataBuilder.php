<?php

namespace App\Elavon\Converge2\Request\Payload;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;
use App\Elavon\Converge2\Request\Payload\DataSetter\CardSetterTrait;
use App\Elavon\Converge2\Request\Payload\DataSetter\CustomReferenceSetterTrait;
use App\Elavon\Converge2\Request\Payload\DataSetter\CustomFieldsSetterTrait;


class HostedCardDataBuilder extends AbstractDataBuilder
{
    use CardSetterTrait;
    use CustomReferenceSetterTrait;
    use CustomFieldsSetterTrait;

    public function setThreeDSecureV1($value)
    {
        $this->setField(C2ApiFieldName::THREE_D_SECURE_V1, $value);
    }

    public function set3dsPayerAuthenticationResponse($value)
    {
        $builder = new ThreeDSecureV1DataBuilder();
        $builder->setPayerAuthenticationResponse($value);

        $this->setThreeDSecureV1($builder->getData());
    }

    public function setDoVerify($value)
    {
        $this->setField(C2ApiFieldName::DO_VERIFY, $value);
    }
}
