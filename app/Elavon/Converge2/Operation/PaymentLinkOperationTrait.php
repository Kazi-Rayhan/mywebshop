<?php

namespace App\Elavon\Converge2\Operation;

use App\Elavon\Converge2\DataObject\Resource\Endpoint;
use App\Elavon\Converge2\Request\AbstractRequest;
use App\Elavon\Converge2\Request\GenericCreateRequest;
use App\Elavon\Converge2\Request\GenericGetRequest;
use App\Elavon\Converge2\Request\GenericListRequest;
use App\Elavon\Converge2\Request\GenericUpdateRequest;
use App\Elavon\Converge2\Response\PaymentLinkPagedListResponse;
use App\Elavon\Converge2\Response\PaymentLinkResponse;
use App\Elavon\Converge2\Response\ResponseInterface;

/**
 * @method sendAndMakeResponse(AbstractRequest $request)
 * @method castResponseAs($class, ResponseInterface $response)
 */
trait PaymentLinkOperationTrait
{
    /**
     * @param $data
     * @return PaymentLinkResponse
     */
    public function createPaymentLink($data)
    {
        $request = new GenericCreateRequest(Endpoint::PAYMENT_LINK, $data);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(PaymentLinkResponse::class, $response);
    }

    /**
     * @param $id
     * @return PaymentLinkResponse
     */
    public function getPaymentLink($id)
    {
        $request = new GenericGetRequest(Endpoint::PAYMENT_LINK, $id);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(PaymentLinkResponse::class, $response);
    }

    /**
     * @param string $query_str
     * @return PaymentLinkPagedListResponse
     */
    public function getPaymentLinkList($query_str = '')
    {
        $request = new GenericListRequest(Endpoint::PAYMENT_LINK, $query_str);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(PaymentLinkPagedListResponse::class, $response);
    }

    /**
     * @param $id
     * @param $data
     * @return PaymentLinkResponse
     */
    public function updatePaymentLink($id, $data)
    {
        $request = new GenericUpdateRequest(Endpoint::PAYMENT_LINK, $id, $data);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(PaymentLinkResponse::class, $response);
    }
}
