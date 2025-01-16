<?php

namespace App\Elavon\Converge2\Response;

use App\Elavon\Converge2\DataObject\DataGetter\PagedListDataGetterTrait;
use App\Elavon\Converge2\DataObject\Resource\Webhook;

class WebhookPagedListResponse extends Response implements PagedListResponseInterface
{
    use PagedListDataGetterTrait;

    protected function castObjectFields()
    {
        $this->castItems(Webhook::class);
    }
}
