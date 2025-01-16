<?php

namespace App\Elavon\Converge2\DataObject\Resource;

use App\Elavon\Converge2\DataObject\EventType;
use App\Elavon\Converge2\DataObject\ResourceType;

interface NotificationInterface
{
    /**
     * @return string|null
     */
    public function getId();

    /**
     * @return string|null
     */
    public function getHref();

    /**
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * @return string|null
     */
    public function getMerchant();

    /**
     * @return EventType|null
     */
    public function getEventType();

    /**
     * @return ResourceType|null
     */
    public function getResourceType();

    /**
     * @return string|null
     */
    public function getResource();
}