<?php

namespace App\Exports;

use App\Constants\PaymentStatus;

use App\Models\Purchase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class SalesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(): Collection
    {
        return Purchase::select('id', 'reference', 'total', 'status')
            ->where('status', PaymentStatus::APPROVED)
            ->get();
    }
}
