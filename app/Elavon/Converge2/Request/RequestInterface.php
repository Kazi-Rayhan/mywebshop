<?php

namespace App\Elavon\Converge2\Request;

use App\Elavon\Converge2\Message\MessageInterface;

interface RequestInterface extends MessageInterface
{
    /**
     * @return string
     */
    public function getMethod();

    /**
     * @return string
     */
    public function getUri();
}
