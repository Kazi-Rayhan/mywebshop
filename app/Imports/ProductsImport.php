<?php

namespace App\Imports;

use App\Models\Shop;
use App\Services\ShopProductImportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
// WithChunkReading, ShouldQueue
class ProductsImport implements ToCollection, WithHeadingRow, WithChunkReading

{

    public $shop;

    function __construct($shop)
    {
        $this->shop = Shop::find($shop);
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Support\Collection|null
     */
    public function collection(Collection $rows)
    {


        foreach ($rows as $row) {
            (new ShopProductImportService($row, $this->shop))->import();
        }
    }
    public function chunkSize(): int
    {
        return 50;
    }
}
