<?php

namespace App\Elavon\Converge2\Client\Guzzle;

use App\Elavon\Converge2\Client\ClientConfigInterface;
use App\Elavon\Converge2\Client\ClientFactoryInterface;

class GuzzleClientFactory implements ClientFactoryInterface
{
    public function getClient(ClientConfigInterface $c2_config, array $client_config = array())
    {
        return new GuzzleClient($c2_config, $client_config);
    }
}