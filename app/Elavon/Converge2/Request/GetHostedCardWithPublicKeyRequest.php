<?php

namespace App\Elavon\Converge2\Request;

use App\Elavon\Converge2\DataObject\Resource\Endpoint;

class GetHostedCardWithPublicKeyRequest extends AbstractGetRequest
{
    protected $endpoint = Endpoint::HOSTED_CARD;
    protected $keyType = self::KEY_TYPE_PUBLIC;
}