<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $products;
    public function __construct($products)
    {
        $this->products = $products;
    }
    public function collection()
    {
        return $this->products;
    }
    public function headings(): array
    {
        return [
            'id',
            'name', 
            'slug', 
            'sku', 
            'ean', 
            'item',
            'price', 
            'saleprice', 
            'tax', 
            'details', 
            'description', 
            'quantity', 
            'category', 
            'sub_category', 
            'sub_category2', 
            'image',  
            'is_variable',
            'variation',
            'length',
            'width',
            'height',
            'weight',
            'featured',
            'status'
        ];
    }
}
