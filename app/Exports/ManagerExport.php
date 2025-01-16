<?php

namespace App\Exports;

// use Illuminate\Database\Eloquent\Collection;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use TCG\Voyager\Voyager;

class ManagerExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;
    protected $managers;
    public function __construct($data)
    {
        $this->managers = collect($data)->map(function ($info) {
            if (is_object($info)) {
                return collect([
                    $info->companyName, $info->companyLogo, $info->fullName, $info->email, $info->phone, $info->qr
                ]);
            } else {
                $user = User::find($info);
                return collect([
                    $user->getShop()->company_name, $user->getShop()->logo ? Voyager::image($user->getShop()->logo) : $user->getShop()->user_name, $user->name . ' ' . $user->last_name, $user->email, $user->phone, Voyager::image($user->qr)
                ]);
            }
        });
        
    }
    public function headings(): array
    {
        return [
            'Company', 'Company logo', 'Name', 'Email', 'Phone', 'Qr'
        ];
    }
    public function collection()
    {
        return $this->managers;
    }
}
