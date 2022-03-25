<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use phpDocumentor\Reflection\Types\Void_;

class PurchaseController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('permission:show-product|create-product|edit-product|delete-product', ['only'=>['index']]);
        $this->middleware('permission:create-product', ['only'=>['create','store']]);
        $this->middleware('permission:edit-product', ['only'=>['edit','update']]);
        $this->middleware('permission:delete-product', ['only'=>['destroy']]);
    }*/

    /*public function index(Request $request): View
    {
        $text = trim($request->get('text'));
        $products = Product::with([
            'categories' => function ($query) {
                $query->select('id', 'name');
            }
        ])->orderBy('id_category', 'asc')
            ->search($text)
            ->paginate(5, ['id', 'name', 'price', 'photo', 'stock_number', 'visible', 'id_category']);

        return view('purchases.index', compact('products', 'text'));
    }*/

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

            ->get( 'id', 'name', 'price', 'photo', 'stock_number', 'visible', 'id_category');
        dd($product);


        return back();
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
