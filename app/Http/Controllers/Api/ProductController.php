<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index():Collection
    {
        $articulos = Product::all();
        return $articulos;
    }

    public function store(Request $request):Product
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock_number' => 'required',
            'id_category' => 'required',
            'description' => 'required',
            'photo' => 'required',
            'visible' => 'required',

        ]);
        $category = DB::table('categories')
            ->select('id')
            ->where('name', '=', $request->id_category)
            ->orWhere('id', '=', $request->id_category)
            ->get();


        if ($request->input('visible') == 'Yes') {
            $visible = true;
        } else {
            $visible = false;
        }
        $product = new Product();
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->stock_number = $request->input('stock_number');
        $product->id_category = $category[0]->id;
        $product->description = $request->input('description');
        $product->photo = $request->input('photo');
        $product->visible = $visible;
        $product->save();

        return $product;
    }
    public function update(Request $request):Product
    {

        if ($request->input('visible') == 'Yes') {
            $request['visible'] = true;
        } else {
            $request['visible'] = false;
        }

        $category = DB::table('categories')
            ->select('id')
            ->where('name', $request->id_category)
            ->orWhere('id', $request->id_category)
            ->first();
        $request['id_category'] = $category->id;
        $product = Product::find($request->id);

        $product->update($request->only(
            'name',
            'price',
            'stock_number',
            'id_category',
            'description',
            'photo',
            'visible',
        ));
        return $product;
    }

    public function destroy(Request $request):Collection
    {
        Product::destroy($request->id);
        $articulo = Product::all();
        return $articulo;
    }
}
