<?php

namespace App\Imports;

use App\Models\ProductImport;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ProductImport([      
            'product_name'  => $row['name'],
            'category' => $row['category'],
            'brand' => $row['brand'],
            'price' => $row['price'],
            'qty' => $row['qty'],
            'img' => $row['image'],
            'highlight' => $row['description'],
        ]);
    }
}
