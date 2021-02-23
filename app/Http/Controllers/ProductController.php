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
            'description' => $request->description,
            'image_url' => $imageUrl,
            'base_price_url' => $request->base_price_url,
        ]);

        $product->save();

        return redirect(route('products.index'))->with('message', 'محصول جدید با موفقیت ایجاد شد.')->with('type', 'success');
    }

    public function show(Product $product)
    {
        //
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        if($request->hasFile('image_file')){
            $image = $request->image_file;
            $fileName = time().'.'.$image->getClientOriginalName();
            $image->move('resources/assets/images/category_images/', $fileName);
            $imageUrl = '/resources/assets/images/category_images/'.$fileName;
            $product->update(['image_url' => $imageUrl]);
        }

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'base_price_url' => $request->base_price_url,
            'is_active' => $request->is_active ? 1 : 0
        ]);

        return redirect(route('products.index'))->with('message', 'محصول با موفقیت بروزرسانی شد.')->with('type', 'success');
    }

    public function destroy(Product $product)
    {
        return redirect('/admin/products')->with('message', 'در حال حاضر امکان حذف وجود ندارد.')->with('type', 'danger');
    }
}
