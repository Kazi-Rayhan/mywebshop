<?php

namespace App\Elavon\Converge2\Client\Response;

use App\Elavon\Converge2\Response\ResponseInterface;

interface ResponseFactoryInterface
{
    /**
     * @param RawResponseInterface $raw_response
     * @return ResponseInterface
     */
    public function create20xResponse(RawResponseInterface $raw_response);

    /**
     * @param \Exception $e
     * @return ResponseInterface
     */
    public function createExceptionResponse(\Exception $e);
}