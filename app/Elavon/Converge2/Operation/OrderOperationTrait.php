<?php

namespace App\Elavon\Converge2\Operation;

use App\Elavon\Converge2\DataObject\Resource\Endpoint;
use App\Elavon\Converge2\Request\AbstractRequest;
use App\Elavon\Converge2\Request\GenericCreateRequest;
use App\Elavon\Converge2\Request\GenericGetRequest;
use App\Elavon\Converge2\Request\GenericListRequest;
use App\Elavon\Converge2\Request\GenericUpdateRequest;
use App\Elavon\Converge2\Response\OrderPagedListResponse;
use App\Elavon\Converge2\Response\OrderResponse;
use App\Elavon\Converge2\Response\ResponseInterface;

/**
 * @method sendAndMakeResponse(AbstractRequest $request)
 * @method castResponseAs($class, ResponseInterface $response)
 */
trait OrderOperationTrait
{
    /**
     * @param $data
     * @return OrderResponse
     */
    public function createOrder($data)
    {
        $request = new GenericCreateRequest(Endpoint::ORDER, $data);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(OrderResponse::class, $response);
    }

    /**
     * @param $id
     * @return OrderResponse
     */
    public function getOrder($id)
    {
        $request = new GenericGetRequest(Endpoint::ORDER, $id);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(OrderResponse::class, $response);
    }

    /**
     * @param string $query_str
     * @return OrderPagedListResponse
     */
    public function getOrderList($query_str = '')
    {
        $request = new GenericListRequest(Endpoint::ORDER, $query_str);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(OrderPagedListResponse::class, $response);
    }

    /**
     * @param $id
     * @param $data
     * @return OrderResponse
     */
    public function updateOrder($id, $data)
    {
        $request = new GenericUpdateRequest(Endpoint::ORDER, $id, $data);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(OrderResponse::class, $response);
    }
}
