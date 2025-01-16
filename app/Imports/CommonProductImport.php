<?php

namespace App\Imports;

use App\Models\Product;
use App\Services\ProductImportService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithChunkReading;
class CommonProductImport implements ToCollection , WithHeadingRow
{


    /**
    * @param array $row
    *
    * @return \Illuminate\Support\Collection|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            ProductImportService::import($row);
        }
    }
}
