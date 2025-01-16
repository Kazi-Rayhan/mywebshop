<?php

namespace App\Elavon\Converge2\Operation;

use App\Elavon\Converge2\DataObject\Resource\Endpoint;
use App\Elavon\Converge2\Request\AbstractRequest;
use App\Elavon\Converge2\Request\GenericCreateRequest;
use App\Elavon\Converge2\Request\GenericGetRequest;
use App\Elavon\Converge2\Response\ForexAdviceResponse;
use App\Elavon\Converge2\Response\ResponseInterface;

/**
 * @method sendAndMakeResponse(AbstractRequest $request)
 * @method castResponseAs($class, ResponseInterface $response)
 */
trait ForexAdviceOperationTrait
{
    /**
     * @param $data
     * @return ForexAdviceResponse
     */
    public function createForexAdvice($data)
    {
        $request = new GenericCreateRequest(Endpoint::FOREX_ADVICE, $data);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(ForexAdviceResponse::class, $response);
    }

    /**
     * @param $id
     * @return ForexAdviceResponse
     */
    public function getForexAdvice($id)
    {
        $request = new GenericGetRequest(Endpoint::FOREX_ADVICE, $id);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(ForexAdviceResponse::class, $response);
    }
}
