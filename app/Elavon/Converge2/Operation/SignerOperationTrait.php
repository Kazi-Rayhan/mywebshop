<?php

namespace App\Elavon\Converge2\Operation;

use App\Elavon\Converge2\DataObject\Resource\Endpoint;
use App\Elavon\Converge2\Request\AbstractRequest;
use App\Elavon\Converge2\Request\GenericCreateRequest;
use App\Elavon\Converge2\Request\GenericDeleteRequest;
use App\Elavon\Converge2\Request\GenericGetRequest;
use App\Elavon\Converge2\Response\SignerResponse;
use App\Elavon\Converge2\Response\ResponseInterface;

/**
 * @method sendAndMakeResponse(AbstractRequest $request)
 * @method castResponseAs($class, ResponseInterface $response)
 */
trait SignerOperationTrait
{
    /**
     * @param $data
     * @return SignerResponse
     */
    public function createSigner($data)
    {
        $request = new GenericCreateRequest(Endpoint::SIGNER, $data);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(SignerResponse::class, $response);
    }

    /**
     * @param $id
     * @return SignerResponse
     */
    public function getSigner($id)
    {
        $request = new GenericGetRequest(Endpoint::SIGNER, $id);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(SignerResponse::class, $response);
    }

    /**
     * @param $id
     * @return SignerResponse
     */
    public function deleteSigner($id)
    {
        $request = new GenericDeleteRequest(Endpoint::SIGNER, $id);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(SignerResponse::class, $response);
    }
}
