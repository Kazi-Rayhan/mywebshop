<?php

namespace App\Elavon\Converge2\Handler;

use App\Elavon\Converge2\Response\ResponseInterface;

interface ResponseHandlerInterface
{
    /**
     * @param ResponseInterface $response
     * @return null
     */
    public function handle(ResponseInterface $response);
}
