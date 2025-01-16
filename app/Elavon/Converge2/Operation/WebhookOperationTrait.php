<?php

namespace App\Elavon\Converge2\Operation;

use App\Elavon\Converge2\DataObject\Resource\Endpoint;
use App\Elavon\Converge2\Request\AbstractRequest;
use App\Elavon\Converge2\Request\GenericCreateRequest;
use App\Elavon\Converge2\Request\GenericDeleteRequest;
use App\Elavon\Converge2\Request\GenericGetRequest;
use App\Elavon\Converge2\Request\GenericListRequest;
use App\Elavon\Converge2\Request\GenericUpdateRequest;
use App\Elavon\Converge2\Request\ListWebhookSignerRequest;
use App\Elavon\Converge2\Response\SignerPagedListResponse;
use App\Elavon\Converge2\Response\WebhookPagedListResponse;
use App\Elavon\Converge2\Response\WebhookResponse;
use App\Elavon\Converge2\Response\ResponseInterface;

/**
 * @method sendAndMakeResponse(AbstractRequest $request)
 * @method castResponseAs($class, ResponseInterface $response)
 */
trait WebhookOperationTrait
{
    /**
     * @param $data
     * @return WebhookResponse
     */
    public function createWebhook($data)
    {
        $request = new GenericCreateRequest(Endpoint::WEBHOOK, $data);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(WebhookResponse::class, $response);
    }

    /**
     * @param $id
     * @return WebhookResponse
     */
    public function getWebhook($id)
    {
        $request = new GenericGetRequest(Endpoint::WEBHOOK, $id);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(WebhookResponse::class, $response);
    }

    /**
     * @param string $query_str
     * @return WebhookPagedListResponse
     */
    public function getWebhookList($query_str = '')
    {
        $request = new GenericListRequest(Endpoint::WEBHOOK, $query_str);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(WebhookPagedListResponse::class, $response);
    }

    /**
     * @param string $webhook_id
     * @param string $query_str
     * @return SignerPagedListResponse
     */
    public function getWebhookSignerList($webhook_id, $query_str = '')
    {
        $request = new ListWebhookSignerRequest($webhook_id, $query_str);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(SignerPagedListResponse::class, $response);
    }

    /**
     * @param $id
     * @param $data
     * @return WebhookResponse
     */
    public function updateWebhook($id, $data)
    {
        $request = new GenericUpdateRequest(Endpoint::WEBHOOK, $id, $data);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(WebhookResponse::class, $response);
    }

    /**
     * @param $id
     * @return WebhookResponse
     */
    public function deleteWebhook($id)
    {
        $request = new GenericDeleteRequest(Endpoint::WEBHOOK, $id);
        $response = $this->sendAndMakeResponse($request);

        return $this->castResponseAs(WebhookResponse::class, $response);
    }
}
