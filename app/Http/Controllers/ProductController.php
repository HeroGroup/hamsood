<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::pluck('title','id')->toArray();
        return view('admin.products.create', compact('categories'));
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

        if ($request->has('categories') && count($request->categories) > 0) {
            $categories = $request->categories;
            for($i=0; $i<count($categories); $i++) {
                ProductCategory::create([
                    'product_id' => $product->id,
                    'category_id' => $categories[$i]
                ]);
            }
        }

        return redirect(route('products.index'))->with('message', 'محصول جدید با موفقیت ایجاد شد.')->with('type', 'success');
    }

    public function show(Product $product)
    {
        //
    }

    public function edit(Product $product)
    {
        $categories = Category::pluck('title','id')->toArray();
        // $ag = GroupRow::where('group_id', $group->id)->get();
        // $allocatedGateways = [];
        // if ($ag->count() > 0)
        //     foreach ($ag as $allocatedGateway)
        //         array_push($allocatedGateways, $allocatedGateway->gateway_id);

        $allocatedCategories = ProductCategory::where('product_id',$product->id)->pluck('category_id','id')->toArray();
        return view('admin.products.edit', compact('product','categories','allocatedCategories'));
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

        if ($request->has('categories') && count($request->categories) > 0) {
            ProductCategory::where('product_id',$product->id)->delete();

            $categories = $request->categories;
            for($i=0; $i<count($categories); $i++) {
                ProductCategory::create([
                    'product_id' => $product->id,
                    'category_id' => $categories[$i]
                ]);
            }
        }

        return redirect(route('products.index'))->with('message', 'محصول با موفقیت بروزرسانی شد.')->with('type', 'success');
    }

    public function destroy(Product $product)
    {
        return redirect('/admin/products')->with('message', 'در حال حاضر امکان حذف وجود ندارد.')->with('type', 'danger');
    }
}
