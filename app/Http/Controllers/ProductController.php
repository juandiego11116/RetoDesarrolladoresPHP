<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;

class ProductController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:showProduct | createProduct | editProduct | deleteProduct', ['only'=>['index']]);
        $this->middleware('permission:createProduct', ['only'=>['create','store']]);
        $this->middleware('permission:editProduct', ['only'=>['edit','update']]);
        $this->middleware('permission:deleteProduct', ['only'=>['destroy']]);

    }

    public function index()
    {
        $product = product::paginate(5);
        return view('products.index');
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
            'stock' => 'required',
            'description' => 'required',
            'photo' => 'required',
        ]);
        product::create($request->all());
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function edit(product $product)
    {
        return view('products.edit', compact('product'));
    }

   public function update(Request $request, product $product)
    {
        request()->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'description' => 'required',
            'photo' => 'required',
        ]);
        $product->update($request->all());
        return redirect()->route('products.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
