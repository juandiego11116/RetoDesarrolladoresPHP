<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WelcomeController extends Controller
{
    public function index(): View
    {
        $products = Product::inRandomOrder()
            ->where('visible', true)
            ->where('stock_number', '>', 0)
            ->with([
                'categories' => function ($query) {
                    $query->select('id', 'name');
                }
            ])->paginate(8);

        $count = Cart::count();

        return view('welcome', compact('products', 'count'));
    }
}
