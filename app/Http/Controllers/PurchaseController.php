<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Placetopay\PaymentGatewayContract;
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

    public function show(int $productId)
    {
        $product = Product::with([
            'categories' => function ($query) {
                $query->select('id', 'name');
            }
        ])->where('id', $productId)
          ->get(['id', 'name', 'price', 'photo', 'stock_number', 'visible', 'id_category']);

        return view('purchases.show', compact('product'));
    }
    public function store(Request $request)
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
