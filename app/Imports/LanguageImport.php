<?php

namespace App\Imports;

use App\Models\Language;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LanguageImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $arr = Schema::getColumnListing('languages');
        $exclude = ['id', 'created_at', 'updated_at','shopCanEdit','english_options','spanish_options','norwegian_options','swedish_options','help'];
        foreach ($exclude as $val) {
            $key =  array_search($val, $arr, true);
            unset($arr[$key]);
        };
        
        $arr = [...$arr];

        $new_arr = [];
        
        foreach ($arr as $key) {
            $new_arr[$key] = $row[$key];
        }

        return Language::updateOrCreate([
            'key' =>  $row['key']
        ], $new_arr);
    }
}
