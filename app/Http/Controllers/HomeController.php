<?php

namespace App\Http\Controllers;

use App\AvailableProduct;
use App\AvailableProductDetail;
use App\Customer;
use App\Order;
use App\OrderItem;
use App\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function checkIfUserBought($availableProductId)
    {
        $userBought = false;
        $mobile = session('mobile');
        if ($mobile && strlen($mobile) == 11) {
            $customer = Customer::where('mobile', 'like', $mobile)->first();
            if ($customer) {
                $order = Order::where('customer_id', $customer->id)->where('status', 1)->first();
                if ($order) {
                    $items = OrderItem::where('order_id', $order->id)->where('available_product_id', $availableProductId)->count();
                    if ($items > 0)
                        $userBought = true;
                }
            }
        }

        return $userBought;
    }

    public function landing()
    {
        $product = Product::where('is_active',1)->first();
        if ($product) {
            $availableProduct = AvailableProduct::where('product_id', $product->id)->where('is_active', 1)->first();
            $details = AvailableProductDetail::where('available_product_id', $availableProduct->id)->get();
            $remaining = $this->getRemainingTime($availableProduct->available_until_datetime);

            $items = OrderItem::where('available_product_id', $availableProduct->id)->select('order_id')->distinct()->get();
            $peopleBought = (Order::whereIn('id', $items)->where('status', 1)->count()) % $availableProduct->maximum_group_members;

            $userBought = $this->checkIfUserBought($availableProduct->id);

            return view('landing', compact('product', 'availableProduct', 'details', 'remaining', 'peopleBought', 'userBought'));
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

    public function verifyMobile()
    {
        return view('verifyMobile');
    }

    public function verifyToken()
    {
        return view('verifyToken');
    }
}
