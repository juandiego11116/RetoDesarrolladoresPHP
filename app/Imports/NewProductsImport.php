<?php

namespace App\Imports;

use App\Models\Product;
use App\Rules\ProductRules;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class NewProductsImport implements ToModel, ShouldQueue, WithHeadingRow, WithValidation, WithChunkReading
{
    /**
     * @param array $row
     *
     * @return Model|null
     */
    public function model(array $row):Product
    {
        return  new Product([
            'name' => Arr::get($row, 'name'),
            'price' => Arr::get($row, 'price'),
            'stock_number' => Arr::get($row, 'stock_number'),
            'id_category' => Arr::get($row, 'id_category'),
            'description' => Arr::get($row, 'description'),
            'photo' => Arr::get($row, 'photo'),
            'visible' => Arr::get($row, 'visible'),
        ]);
    }

    public function chunkSize(): int
    {
        return 100;
    }

    public function rules(): array
    {
        return ProductRules::toArray();
    }
}
