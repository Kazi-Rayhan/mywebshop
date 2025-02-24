<?php

namespace App\Elavon\Converge2\Operation;

use App\Elavon\Converge2\DataObject\Resource\Endpoint;
use App\Elavon\Converge2\Request\AbstractRequest;
use App\Elavon\Converge2\Request\GenericGetRequest;
use App\Elavon\Converge2\Request\GenericListRequest;
use App\Elavon\Converge2\Response\NotificationPagedListResponse;
use App\Elavon\Converge2\Response\NotificationResponse;
use App\Elavon\Converge2\Response\ResponseInterface;

/**
 * @method sendAndMakeResponse(AbstractRequest $request)
 * @method castResponseAs($class, ResponseInterface $response)
 */
trait NotificationOperationTrait
{
    /**
     * @param $id
     * @return NotificationResponse
     */
    public function getNotification($id)
    {
        $request = new GenericGetRequest(Endpoint::NOTIFICATION, $id);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(NotificationResponse::class, $response);
    }

    /**
     * @param string $query_str
     * @return NotificationPagedListResponse
     */
    public function getNotificationList($query_str = '')
    {
        $request = new GenericListRequest(Endpoint::NOTIFICATION, $query_str);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(NotificationPagedListResponse::class, $response);
    }
}
