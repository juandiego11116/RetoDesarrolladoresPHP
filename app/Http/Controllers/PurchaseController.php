<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Placetopay\PaymentGatewayContract;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use phpDocumentor\Reflection\Types\Void_;

class PurchaseController extends Controller
{
    public function create(Request $request): View
    {
        $input = $request->get('product');
        $quantity = $request->get('amount');

        $product = DB::table('products')
            ->select('id', 'name', 'price')
            ->where('id', $input)
            ->orderBy('name', 'asc')
            ->paginate(5);

        return view('purchases.cart', compact('product', 'input', 'quantity'));
    }

    public function show( int $purchase):View
    {

        $purchases = DB::table('purchases')
            ->select('id','id_request', 'total', 'status', 'deduct_from_stock', 'reference')
            ->where('id', $purchase)
            ->get();
        $reference = $purchases[0]->reference;
        $products = DB::table('purchase_product')
            ->join('products', 'purchase_product.product_id', '=', 'products.id')
            ->select('products.id','products.name', 'purchase_product.amount', 'purchase_product.subtotal', 'purchase_product.price', 'products.stock_number')
            ->where('purchase_id',  $purchases[0]->id)
            ->get();

        return view('purchases.show', compact('purchases', 'products', 'reference'));

    }
    public function store(Request $request): RedirectResponse
    {
        $text = trim($request->get('id'));

        $product = Product::with([
            'categories' => function ($query) {
                $query->select('id', 'name');
            }
        ])

            ->get('id', 'name', 'price', 'photo', 'stock_number', 'visible', 'id_category');
        dd($product);


        return back();
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

    public function addToCart(Request $request): View
    {
        $products = Product::with([
            'categories' => function ($query) {
                $query->select('id', 'name');
            }
        ])->where('id', '=', $request->query('productId'))
            ->orderBy('id_category', 'asc')
            ->paginate(5, ['id', 'name', 'price', 'photo', 'stock_number', 'visible', 'id_category']);

        return view('purchases.cart', compact('products'));
    }
}
