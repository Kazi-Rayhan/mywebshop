<?php

namespace App\Elavon\Converge2\Response;

use App\Elavon\Converge2\DataObject\DataGetter\PagedListDataGetterTrait;
use App\Elavon\Converge2\DataObject\Resource\Batch;

class BatchPagedListResponse extends Response implements PagedListResponseInterface
{
    use PagedListDataGetterTrait;

    protected function castObjectFields()
    {
        $this->castItems(Batch::class);
    }
}
