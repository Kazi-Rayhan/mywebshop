<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class TicketCloseAction extends AbstractAction
{
    public function getTitle()
    {
        return 'Close';
    }

    public function getIcon()
    {
        return 'voyager-x';
    }

    public function getPolicy()
    {
        return 'browse';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-danger pull-right',
        ];
    }

    public function getDefaultRoute()
    {
        return route('ticket.close',$this->data->id);
    }
    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'tickets';
    }
}