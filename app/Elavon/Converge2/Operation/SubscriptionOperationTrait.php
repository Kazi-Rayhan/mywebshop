<?php

namespace App\Elavon\Converge2\Operation;

use App\Elavon\Converge2\DataObject\Resource\Endpoint;
use App\Elavon\Converge2\Request\AbstractRequest;
use App\Elavon\Converge2\Request\GenericCreateRequest;
use App\Elavon\Converge2\Request\GenericGetRequest;
use App\Elavon\Converge2\Request\GenericListRequest;
use App\Elavon\Converge2\Request\GenericUpdateRequest;
use App\Elavon\Converge2\Response\SubscriptionPagedListResponse;
use App\Elavon\Converge2\Response\SubscriptionResponse;
use App\Elavon\Converge2\Response\ResponseInterface;

/**
 * @method sendAndMakeResponse(AbstractRequest $request)
 * @method castResponseAs($class, ResponseInterface $response)
 */
trait SubscriptionOperationTrait
{
    /**
     * @param $data
     * @return SubscriptionResponse
     */
    public function createSubscription($data)
    {
        $request = new GenericCreateRequest(Endpoint::SUBSCRIPTION, $data);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(SubscriptionResponse::class, $response);
    }

    /**
     * @param $id
     * @return SubscriptionResponse
     */
    public function getSubscription($id)
    {
        $request = new GenericGetRequest(Endpoint::SUBSCRIPTION, $id);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(SubscriptionResponse::class, $response);
    }

    /**
     * @param string $query_str
     * @return SubscriptionPagedListResponse
     */
    public function getSubscriptionList($query_str = '')
    {
        $request = new GenericListRequest(Endpoint::SUBSCRIPTION, $query_str);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(SubscriptionPagedListResponse::class, $response);
    }

    /**
     * @param $id
     * @param $data
     * @return SubscriptionResponse
     */
    public function updateSubscription($id, $data)
    {
        $request = new GenericUpdateRequest(Endpoint::SUBSCRIPTION, $id, $data);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(SubscriptionResponse::class, $response);
    }
}
