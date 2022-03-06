<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show-product|create-product|edit-product|delete-product', ['only'=>['index']]);
        $this->middleware('permission:create-product', ['only'=>['create','store']]);
        $this->middleware('permission:edit-product', ['only'=>['edit','update']]);
        $this->middleware('permission:delete-product', ['only'=>['destroy']]);
    }

    public function index(Request $request): View
    {
        $text = trim($request->get('text'));
        $products = DB::table('products')
            ->select('id', 'name', 'price', 'stock_number', 'category')
            ->where('name', 'LIKE', '%'.$text.'%')
            ->orWhere('price', 'LIKE', '%'.$text.'%')
            ->orWhere('stock_number', 'LIKE', '%'.$text.'%')
            ->orWhere('category', 'LIKE', '%'.$text.'%')
            ->orderBy('name', 'asc')
            ->paginate(5);
        return view('purchases.index', compact('products', 'text'));
    }
    public function create(Request $request): View
    {
        $input = $request->get('product');
        $amount = $request->get('amount');

        $product = DB::table('products')
            ->select('id', 'name', 'price')
            ->where('id', '=', $input)
            ->orderBy('name', 'asc')
            ->paginate(5);

        return view('purchases.cart', compact('product', 'input', 'amount'));
    }
    public function addToCart(Request $request): View
    {
        $product = ProductController::find($request->product);

        return view('purchases.cart', compact('product'));
    }
}
