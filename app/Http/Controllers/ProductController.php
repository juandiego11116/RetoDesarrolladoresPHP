<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\product;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:show-product|create-product|edit-product|delete-product', ['only'=>['index']]);
        $this->middleware('permission:create-product', ['only'=>['create','store']]);
        $this->middleware('permission:edit-product', ['only'=>['edit','update']]);
        $this->middleware('permission:delete-product', ['only'=>['destroy']]);
    }

    public function index()
    {
        $products = product::paginate(5);
        return view('products.index', compact('products'));
    }

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
        product::create($request->only(
            'name',
            'price',
            'stock_number',
            'category',
            'description',
            'photo',
        ));//inyectar los datos validados
        return redirect()->route('products.index');
    }

    public function edit(product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'price' => 'required',
            'stock_number' => 'required',
            'category' => 'required',
            'description' => 'required',
            'photo' => 'required',
        ]);


        $product = product::find($id);
        $product->update($request->only(
            'name',
            'price',
            'stock_number',
            'category',
            'description',
            'photo',
        ));
        return redirect()->route('products.index');
    }


    public function destroy(product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
