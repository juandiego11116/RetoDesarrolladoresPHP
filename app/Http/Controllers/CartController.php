<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $product = Product::find($request->productId);

        Cart::add($product->id, $product->name, $request->quantity, $product->price);

        return back();
    }

    public function index()
    {
        $products =  Cart::content();
        if ($products->isEmpty()) {
            return redirect()->route('welcome')->with('status', 'The cart is void');
        }
        return view('cart', compact('products'));
    }

    public function delete(Request $request): RedirectResponse
    {
        Cart::remove($request->rowId);

        return back();
    }

    public function update(Request $request): RedirectResponse
    {
        Cart::update($request->rowId, $request->quantity);
        return back();
    }

    public function show(int $productId)
    {
        $product = Product::with([
            'categories' => function ($query) {
                $query->select('id', 'name');
            }
        ])->where('id', $productId)
            ->get(['id', 'name', 'price', 'photo', 'stock_number', 'visible', 'id_category']);

        return view('show', compact('product'));
    }
}
