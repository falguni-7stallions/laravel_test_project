<?php

namespace App\Exports;

use App\Models\product;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class ProductExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return product::all()->map(function ($product){
            return [
                $product->name,
                $product->description,
                $product->price,
            ];
        });

    }
    public function headings(): array
    {
        return [
            'Name',
            'Description',
            'Price',
        ];
    }
}
