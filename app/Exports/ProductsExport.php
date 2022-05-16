<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, WithHeadings, FromQuery, ShouldQueue
{
    use Exportable;

    public function collection(): Collection
    {
        return Product::select('id', 'name', 'price', 'stock_number', 'id_category', 'description', 'visible')
            ->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'price',
            'stock_number',
            'id_category',
            'description',
            'visible',
        ];
    }

    public function query(): Collection
    {
        return Product::query('id', 'name', 'price', 'stock_number', 'id_category', 'description', 'visible')
            ->get();
    }
}
