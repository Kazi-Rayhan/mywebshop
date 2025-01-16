<?php

namespace App\Elavon\Converge2\Response;

use App\Elavon\Converge2\DataObject\DataGetter\PagedListDataGetterTrait;
use App\Elavon\Converge2\DataObject\Resource\Subscription;

class SubscriptionPagedListResponse extends Response implements PagedListResponseInterface
{
    use PagedListDataGetterTrait;

    protected function castObjectFields()
    {
        $this->castItems(Subscription::class);
    }
}
