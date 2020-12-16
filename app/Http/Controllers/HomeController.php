<?php

namespace App\Http\Controllers;

use App\AvailableProduct;
use App\AvailableProductDetail;
use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function landing()
    {
        $product = Product::where('is_active',1)->first();
        $availableProduct = AvailableProduct::where('product_id',$product->id)->where('is_active',1)->first();
        $details = AvailableProductDetail::where('available_product_id',$availableProduct->id)->get();

        // product name, description, picture, base price, discount list, number of people bought,
        return view('landing', compact('product','availableProduct', 'details'));
    }
}
