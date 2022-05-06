<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    public function show(int $purchase): View
    {
        $purchases = DB::table('purchases')
            ->select('id', 'id_request', 'total', 'status', 'deduct_from_stock', 'reference')
            ->where('id', $purchase)
            ->get();

        $reference = $purchases[0]->reference;

        $products = DB::table('purchase_product')
            ->join('products', 'purchase_product.product_id', '=', 'products.id')
            ->select('products.id', 'products.name', 'purchase_product.amount', 'purchase_product.subtotal', 'purchase_product.price', 'products.stock_number')
            ->where('purchase_id', $purchases[0]->id)
            ->get();

        return view('purchases.show', compact('purchases', 'products', 'reference'));
    }

    public function history(Request $request): View
    {
        $text = trim($request->get('text'));

        $purchases = DB::table('purchases')
            ->select('id', 'reference', 'total', 'status')
            ->where('total', 'LIKE', '%'.$text.'%')
            ->orWhere('reference', 'LIKE', '%'.$text.'%')
            ->orWhere('status', 'LIKE', '%'.$text.'%')
            ->orderBy('status', 'asc')
            ->paginate(5);

        return view('purchases.history', compact('purchases', 'text'));
    }

}
