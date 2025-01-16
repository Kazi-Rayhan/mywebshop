<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class ReplyAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Reply';
    }

    public function getIcon()
    {
        return 'voyager-eye';
    }

    public function getPolicy()
    {
        return 'browse';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-success pull-right',
        ];
    }

    public function getDefaultRoute()
    {
        return route('voyager.tickets.show',$this->data->id);
    }
    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'tickets';
    }
}