<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Exports\SalesExport;
use App\Imports\ProductsImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    public function index(): View
    {
        return view('reports.index');
    }

    public function productImport(Request $request): RedirectResponse
    {
        $file = $request->file('file');

        try {
            Excel::queueImport(new ProductsImport(), $file, 'local', \Maatwebsite\Excel\Excel::CSV);
        } catch (\Throwable $throwable) {
            dd($throwable);
        }
        return redirect()->route('products.index');
    }

    public function exportProducts(): BinaryFileResponse
    {
        return Excel::download(new ProductsExport(), 'products-export.xlsx');
    }

    public function exportSale(): BinaryFileResponse
    {
        return  Excel::download(new SalesExport(), 'sales-export.csv');
    }
}
