<?php

namespace App\Http\Controllers;

use App\AvailableProduct;
use App\AvailableProductDetail;
use App\City;
use App\Customer;
use App\Neighbourhood;
use App\Order;
use App\OrderItem;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                $orderMaxId = Order::where('customer_id', $customer->id)/*->where('status', 1)*/->max('id');
                if($orderMaxId) {
                  $order = Order::find($orderMaxId);
                  if ($order) {
                      $items = OrderItem::where('order_id', $order->id)->where('available_product_id', $availableProductId)->count();
                      if ($items > 0)
                          $userBought = true;
                  }
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
            $remaining = $this->getRemainingTime($availableProduct->until_day,$availableProduct->available_until_datetime);

            /*
            $items = OrderItem::where('available_product_id', $availableProduct->id)->select('order_id')->distinct()->get();
            $peopleBought = (Order::whereIn('id', $items)->where('status', 1)->count()) % $availableProduct->maximum_group_members;
            */

            $peopleBought = $availableProduct->getOrdersCount();
            $userBought = $this->checkIfUserBought($availableProduct->id);

            $nextDiscount = $peopleBought > 1 ? $details[$peopleBought-1]->discount : $details->min('discount');
            $lastDiscount = $peopleBought > 1 ? $details[$peopleBought-2]->discount : $details->min('discount');

            session(['mobile' => "09177048781"]);

            return view('customers.landing', compact('product', 'availableProduct', 'details', 'remaining', 'peopleBought', 'userBought', 'nextDiscount', 'lastDiscount'));
        } else {
            return view('customers.notActive');
        }
    }

    public function getRemainingTime($day,$end)
    {
        // $iranStandardTime = 12600;
        $hour = $end - 1;

        $jalali = explode('/', $day);
        $date = strtotime(jalali_to_gregorian($jalali[0], $jalali[1], $jalali[2], '/') . " $hour:59:59");
        return $date - time();
    }

    public function verifyMobile()
    {
        return view('customers.verifyMobile');
    }

    public function verifyToken()
    {
        $remainingTime = 60;
        return view('customers.verifyToken', compact('remainingTime'));
    }
}
