<?php

namespace App\Exports;

use App\Models\Language;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LanguageExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        $arr = Schema::getColumnListing('languages');
        $exclude = ['id', 'created_at', 'updated_at'];
        foreach ($exclude as $val) {
            $key =  array_search($val, $arr, true);
            unset($arr[$key]);
        };
        $arr = [...$arr];
        return $arr;
    }
    public function collection()
    {
        $arr = Schema::getColumnListing('languages');
        $exclude = ['id', 'created_at', 'updated_at'];
        foreach ($exclude as $val) {
            $key =  array_search($val, $arr, true);
            unset($arr[$key]);
        };
        $arr = [...$arr];
        return Language::select($arr)->get();
    }
}
