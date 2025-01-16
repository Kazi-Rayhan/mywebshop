<?php

namespace App\Elavon\Converge2\Operation;

use App\Elavon\Converge2\DataObject\Resource\Endpoint;
use App\Elavon\Converge2\Request\AbstractRequest;
use App\Elavon\Converge2\Request\GenericCreateRequest;
use App\Elavon\Converge2\Request\GenericDeleteRequest;
use App\Elavon\Converge2\Request\GenericGetRequest;
use App\Elavon\Converge2\Request\GenericListRequest;
use App\Elavon\Converge2\Request\GenericUpdateRequest;
use App\Elavon\Converge2\Response\PlanPagedListResponse;
use App\Elavon\Converge2\Response\PlanResponse;
use App\Elavon\Converge2\Response\ResponseInterface;

/**
 * @method sendAndMakeResponse(AbstractRequest $request)
 * @method castResponseAs($class, ResponseInterface $response)
 */
trait PlanOperationTrait
{
    /**
     * @param $data
     * @return PlanResponse
     */
    public function createPlan($data)
    {
        $request = new GenericCreateRequest(Endpoint::PLAN, $data);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(PlanResponse::class, $response);
    }

    /**
     * @param $id
     * @return PlanResponse
     */
    public function getPlan($id)
    {
        $request = new GenericGetRequest(Endpoint::PLAN, $id);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(PlanResponse::class, $response);
    }

    /**
     * @param string $query_str
     * @return PlanPagedListResponse
     */
    public function getPlanList($query_str = '')
    {
        $request = new GenericListRequest(Endpoint::PLAN, $query_str);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(PlanPagedListResponse::class, $response);
    }

    /**
     * @param $id
     * @param $data
     * @return PlanResponse
     */
    public function updatePlan($id, $data)
    {
        $request = new GenericUpdateRequest(Endpoint::PLAN, $id, $data);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(PlanResponse::class, $response);
    }

    /**
     * @param $id
     * @return PlanResponse
     */
    public function deletePlan($id)
    {
        $request = new GenericDeleteRequest(Endpoint::PLAN, $id);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(PlanResponse::class, $response);
    }
}
