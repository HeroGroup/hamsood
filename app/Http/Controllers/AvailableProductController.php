<?php

namespace App\Http\Controllers;

use App\AvailableProduct;
use App\Product;
use Illuminate\Http\Request;

class AvailableProductController extends Controller
{
    public function index()
    {
        $products = [];
        return view('availableProducts.index', compact('products'));
    }

    public function create()
    {
        $products = Product::pluck('name', 'id')->toArray();
        return view('availableProducts.create', compact('products'));
    }

    public function store(Request $request)
    {
        //
    }

    public function show(AvailableProduct $availableProduct)
    {
        //
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
        //
    }
}
