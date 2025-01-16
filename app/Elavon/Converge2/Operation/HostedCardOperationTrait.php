<?php

namespace App\Elavon\Converge2\Operation;

use App\Elavon\Converge2\DataObject\Resource\Endpoint;
use App\Elavon\Converge2\Request\AbstractRequest;
use App\Elavon\Converge2\Request\GenericCreateRequest;
use App\Elavon\Converge2\Request\GenericGetRequest;
use App\Elavon\Converge2\Request\GenericUpdateRequest;
use App\Elavon\Converge2\Request\GetHostedCardWithPublicKeyRequest;
use App\Elavon\Converge2\Request\Payload\HostedCardDataBuilder;
use App\Elavon\Converge2\Response\HostedCardResponse;
use App\Elavon\Converge2\Response\ResponseInterface;

/**
 * @method sendAndMakeResponse(AbstractRequest $request)
 * @method castResponseAs($class, ResponseInterface $response)
 */
trait HostedCardOperationTrait
{
    /**
     * @param $data
     * @return HostedCardResponse
     */
    public function createHostedCard($data)
    {
        $request = new GenericCreateRequest(Endpoint::HOSTED_CARD, $data);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(HostedCardResponse::class, $response);
    }

    /**
     * @param $id
     * @return HostedCardResponse
     */
    public function getHostedCard($id)
    {
        $request = new GenericGetRequest(Endpoint::HOSTED_CARD, $id);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(HostedCardResponse::class, $response);
    }

    /**
     * @param $id
     * @param $data
     * @return HostedCardResponse
     */
    public function updateHostedCard($id, $data)
    {
        $request = new GenericUpdateRequest(Endpoint::HOSTED_CARD, $id, $data);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(HostedCardResponse::class, $response);
    }

    /**
     * @param $id
     * @param $pa_res
     * @return HostedCardResponse
     */
    public function updatePayerAuthenticationResponseInHostedCard($id, $pa_res)
    {
        $hosted_card_builder = new HostedCardDataBuilder();
        $hosted_card_builder->set3dsPayerAuthenticationResponse($pa_res);

        return $this->updateHostedCard($id, $hosted_card_builder->getData());
    }

    /**
     * @param $id
     * @return HostedCardResponse
     */
    public function getHostedCardWithPublicKey($id)
    {
        $request = new GetHostedCardWithPublicKeyRequest($id);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(HostedCardResponse::class, $response);
    }
}
