<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $imageUrl = '';
        if($request->hasFile('image_file')){
            $image = $request->image_file;
            $fileName = time().'.'.$image->getClientOriginalName();
            $image->move('resources/assets/images/category_images/', $fileName);
            $imageUrl = '/resources/assets/images/category_images/'.$fileName;
        }

        $product = new Product([
            'name' => $request->name,
            'description' => $request->descrition,
            'image_url' => $imageUrl
        ]);

        $product->save();

        return redirect(route('products.index'))->with('message', 'محصئل جدید با موفقیت ایجاد شد.')->with('type', 'success');
    }

    public function show(Product $product)
    {
        //
    }

    public function edit(Product $product)
    {
        //
    }

    public function update(Request $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        //
    }
}
