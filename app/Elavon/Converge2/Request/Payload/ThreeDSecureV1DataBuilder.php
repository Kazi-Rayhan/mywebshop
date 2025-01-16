<?php

namespace App\Elavon\Converge2\Request\Payload;

use App\Elavon\Converge2\DataObject\C2ApiFieldName;
use App\Elavon\Converge2\Request\Payload\DataSetter\TotalSetterTrait;

class ThreeDSecureV1DataBuilder extends AbstractDataBuilder
{
    use TotalSetterTrait;

    public function setUserAgent($value)
    {
        $this->setField(C2ApiFieldName::USER_AGENT, $value);
    }

    public function setAcceptHeader($value)
    {
        $this->setField(C2ApiFieldName::ACCEPT_HEADER, $value);
    }

    public function setPayerAuthenticationResponse($value)
    {
        $this->setField(C2ApiFieldName::PAYER_AUTHENTICATION_RESPONSE, $value);
    }
}
