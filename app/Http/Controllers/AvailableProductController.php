<?php

namespace App\Http\Controllers;

use App\AvailableProduct;
use App\AvailableProductDetail;
use App\Product;
use Illuminate\Http\Request;

class AvailableProductController extends Controller
{
    public function index()
    {
        $products = AvailableProduct::where('is_active',1)->get();
        return view('availableProducts.index', compact('products'));
    }

    public function create()
    {
        $products = Product::pluck('name', 'id')->toArray();
        return view('availableProducts.create', compact('products'));
    }

    public function store(Request $request)
    {
        $newProduct = new AvailableProduct($request->all());
        $newProduct->save();
        $defaultDiscounts = [1 => 9, 2 => 12, 3 => 17, 4 => 23, 5 => 26, 6 => 31, 7 => 36, 8 => 38, 9 => 42, 10 => 51];
        return view('availableProducts.details', compact('newProduct', 'defaultDiscounts'));
    }

    public function storeDetails(Request $request)
    {
        if (AvailableProduct::find($request->available_product_id)->maximum_group_members-1 == count($request->levels)) {
            for($i=1;$i<=count($request->levels);$i++) {
                AvailableProductDetail::create([
                    'available_product_id' => $request->available_product_id,
                    'level' => $i,
                    'discount' => $request->levels[$i]
                ]);
            }
        }

        return redirect(route('availableProducts.index'))->with('message', 'گروه محصول جدید با موفقیت ایجاد شد.')->with('type', 'success');
    }

    public function inactive(AvailableProduct $availableProduct)
    {
        $availableProduct->update(['is_active' => 0]);
        return redirect(route('availableProducts.index'))->with('message', 'تغییر وضعیت با موفقیت انجام شد')->with('type', 'success');
    }

    public function edit(AvailableProduct $availableProduct)
    {
        return view('availableProducts.index', compact('availableProduct'));
    }

    public function update(Request $request, AvailableProduct $availableProduct)
    {
        //
    }

    public function destroy(AvailableProduct $availableProduct)
    {
        return redirect('/admin/availableProducts')->with('message', 'در حال حاضر امکان حذف وجود ندارد.')->with('type', 'danger');
    }
}
