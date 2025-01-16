<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class ExportGroupProductButton extends AbstractAction
{
    public function getTitle()
    {
        return 'Export';
    }

    public function getIcon()
    {
        return 'voyager-eye';
    }

    public function getPolicy()
    {
        return 'read';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-primary pull-right',
        ];
    }

    public function getDefaultRoute()
    {
        return route('admin.export_group_product',$this->data->id);
    }
    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'shopgroup';
    }
}
