<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $products = Product::inRandomOrder()
            ->where('visible', true)
            ->where('stock_number', '>', 0)
            ->with([
                'categories' => function ($query) {
                    $query->select('id', 'name');
                }
            ])->paginate(8);


        return view('welcome', compact('products'));
    }
}