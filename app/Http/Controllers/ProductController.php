<?php

namespace App\Http\Controllers;

use App\Models\Category;
use http\Env\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ProductController extends Controller
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
        $products = Product::with([
            'categories' => function ($query) {
                $query->select('id', 'name');
            }
        ])->orderBy('created_at', 'desc')
            ->search($text)
            ->paginate(5, ['id', 'name', 'price', 'photo', 'stock_number', 'visible', 'id_category']);

        return view('products.index', compact('products', 'text'));
    }

    public function create(): View
    {
        $categories = DB::table('categories')
            ->select('id', 'name')
            ->get();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
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

        $file = $request->file('photo');

        $photo = $file->hashName();
        $file->storeAs('public', $photo);
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
        $product->photo = $photo;
        $product->visible = $visible;
        $product->save();

        return redirect()->route('products.index');
    }

    public function edit(Product $product): View
    {
        $categories = DB::table('categories')
            ->select('id', 'name')
            ->get();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'stock_number' => 'required',
            'id_category' => 'required',
            'description' => 'required',
            'photo' => 'required',
            'visible' => 'required',
        ]);
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
        $product = Product::find($id);

        $product->update($request->only(
            'name',
            'price',
            'stock_number',
            'id_category',
            'description',
            'photo',
            'visible',
        ));
        return redirect()->route('products.index');
    }


    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}
