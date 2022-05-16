<?php

namespace App\Imports;

use App\Models\Product;
use App\Rules\UpdateProductRules;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpsertColumns;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProductsImport implements WithUpserts, WithChunkReading, WithValidation, WithHeadingRow, ToCollection, WithUpsertColumns, ShouldQueue
{
    public function collection(Collection $rows): void
    {
        foreach ($rows as $row) {
            $product = Product::where('id', $row['id'])->first();
            if ($product!== null) {
                $product->update(
                    [
                        'name' => $row['name'],
                        'price' => $row['price'],
                        'stock_number' => $row['stock_number'],
                        'id_category' => $row['id_category'],
                        'description' => $row['description'],
                        'visible' => $row['visible'],
                    ]
                );
            } else {
                $product = new Product();

                $product->name = $row['name'];
                $product->price = $row['price'];
                $product->stock_number = $row['stock_number'];
                $product->id_category = $row['id_category'];
                $product->photo = 'a2c2ef61b5d8ed1a0f4bce26d6b20753.png';
                $product->description = $row['description'];
                $product->visible = $row['visible'];
                $product->save();
            }
        }
    }

    public function uniqueBy(): string
    {
        return 'id';
    }


    public function chunkSize(): int
    {
        return 100;
    }

    public function rules(): array
    {
        return UpdateProductRules::toArray();
    }

    public function upsertColumns()
    {
        return [
            'name',
            'price' ,
            'stock_number' ,
            'id_category',
            'description',
            'visible',
        ];
    }
}
