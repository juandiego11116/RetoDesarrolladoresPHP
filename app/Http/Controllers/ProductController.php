<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:showProduct | createProduct | editProduct | deleteProduct', ['only'=>['index']]);
        $this->middleware('permission:createProduct', ['only'=>['create','store']]);
        $this->middleware('permission:editProduct', ['only'=>['edit','update']]);
        $this->middleware('permission:deleteProduct', ['only'=>['destroy']]);
    }

    public function index()
    {
        $products = product::paginate(5);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'price' => 'required',
            'stock_number' => 'required',
            'category' => 'required',
            'description' => 'required',
            'photo' => 'required',
        ]);
        product::create($request->all());
        return redirect()->route('products.index');
    }

    public function edit(product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, product $products)
    {
        request()->validate([
            'name' => 'required',
            'price' => 'required',
            'stock_number' => 'required',
            'category' => 'required',
            'description' => 'required',
            'photo' => 'required',
        ]);

        $products->update($request->all());
        return redirect()->route('products.index');
    }


    public function destroy(product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
