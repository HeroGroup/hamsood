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
        if ($product) {
            $availableProduct = AvailableProduct::where('product_id', $product->id)->where('is_active', 1)->first();
            $details = AvailableProductDetail::where('available_product_id', $availableProduct->id)->get();
            $remaining = $this->getRemainingTime($availableProduct->available_until_datetime);
            $peopleBought = 5 % $availableProduct->maximum_group_members;
            $userBought = false;

            // number of people bought
            return view('landing', compact('product', 'availableProduct', 'details', 'remaining', 'peopleBought'));
        } else {
            return view('landing');
        }
    }

    public function getRemainingTime($end)
    {
        $hour = $end - 1;
        $date = strtotime(date("Y/m/d") . " $hour:59:59 PM");
        return ($date - time() - 12600); // Iran Standard Time
    }
}
