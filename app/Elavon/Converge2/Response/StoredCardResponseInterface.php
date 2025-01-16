<?php

namespace App\Elavon\Converge2\Response;

use App\Elavon\Converge2\DataObject\Resource\StoredCardInterface;

interface StoredCardResponseInterface extends ResponseInterface, StoredCardInterface
{
    /**
     * @return bool
     */
    public function hasFailuresAboutCardAlreadyExists();
}
