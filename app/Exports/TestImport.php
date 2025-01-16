<?php

namespace App\Exports;

use Maatwebsite\Excel\Row;
use Illuminate\Support\Collection;
use App\Models\Import;
// use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class TestImport implements ToCollection, WithHeadingRow
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return User::all();
    // }
    public function collection(Collection $rows)
    {
                foreach ($rows as $row) {
    
            
            $product = Import::where('name', $row['name'])->first();
            if($product != NULL){
                Import::where('name', $row['name'])->update([
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'phone' => $row['phone'],
                    'address' => $row['address'],
               					
                ]);
             } else {
                Import::create([
                        'name' => $row['name'],
                        'email' => $row['email'],
                        'phone' => $row['phone'],
                        'address' => $row['address'],
    
                ]);
            } 
        }
    }
}
