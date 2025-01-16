<?php

namespace App\Elavon\Converge2\Client\Curl;

use App\Elavon\Converge2\Client\Curl\Exception\RequestException;
use App\Elavon\Converge2\Client\Response\AbstractResponseFactory;
use App\Elavon\Converge2\Response\Response;

class CurlResponseFactory extends AbstractResponseFactory
{
    public function createRequestExceptionResponse(RequestException $e)
    {
        $response = new Response();
        $response->setSuccess(false);
        $response->setShortErrorMessage($e->getResponse()->getReasonPhrase());
        $response->setRawErrorMessage($e->getResponse()->getBody());
        $response->setRawResponse($e->getResponse());
        $response->setException($e);
        return $response;
    }
}
