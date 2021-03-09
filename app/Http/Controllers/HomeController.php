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

    public function checkIfUserBought($availableProductId) // in new edition, check if exists in cart
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

    public function landing($reference=null)
    {
        session(['mobile' => '09177048781']);
        $referenceId = "g6Z";
        $products = Product::where('is_active',1)->get();
        $result = [];
        if ($products->count() > 0) {
            foreach ($products as $product) {
                $availableProduct = AvailableProduct::where('product_id', $product->id)->where('is_active', 1)->first();
                if($availableProduct) {
                    $details = AvailableProductDetail::where('available_product_id', $availableProduct->id)->get();
                    $remaining = $this->getRemainingTime($availableProduct->until_day, $availableProduct->available_until_datetime);

                    $peopleBought = $availableProduct->getOrdersCount() % $availableProduct->maximum_group_members;
                    $userBought = $this->checkIfUserBought($availableProduct->id);

                    $nextDiscount = $peopleBought > 1 ? $details[$peopleBought - 1]->discount : $details->min('discount');
                    $lastDiscount = $peopleBought > 1 ? $details[$peopleBought - 2]->discount : $details->min('discount');

                    $item = [
                        'product' => $product,
                        'availableProduct' => $availableProduct,
                        'details' => $details,
                        'remaining' => $remaining,
                        'peopleBought' => $peopleBought,
                        'userBought' => $userBought,
                        'nextDiscount' => $nextDiscount,
                        'lastDiscount' => $lastDiscount
                    ];

                    array_push($result, $item);
                }
            }
            // $referenceId = $userBought ? (Customer::where('mobile', 'like', session('mobile'))->first()->id + 1000) : '';
            return view('customers.landing', compact('result', 'referenceId'));

        } else {
            return view('customers.notActive');
        }
    }

    public function productDetailPage($productId)
    {
        $referenceId = "g6Z";
        $product = Product::find($productId);
        $availableProduct = AvailableProduct::where('product_id', $product->id)->where('is_active', 1)->first();
        if($availableProduct) {
            $details = AvailableProductDetail::where('available_product_id', $availableProduct->id)->get();
            $remaining = $this->getRemainingTime($availableProduct->until_day, $availableProduct->available_until_datetime);

            $peopleBought = $availableProduct->getOrdersCount() % $availableProduct->maximum_group_members;
            $userBought = $this->checkIfUserBought($availableProduct->id);

            $nextDiscount = $peopleBought > 1 ? $details[$peopleBought - 1]->discount : $details->min('discount');
            $lastDiscount = $peopleBought > 1 ? $details[$peopleBought - 2]->discount : $details->min('discount');

            return view('customers.productDetail', compact('product', 'availableProduct', 'details', 'remaining', 'peopleBought', 'userBought', 'nextDiscount', 'lastDiscount', 'referenceId'));
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

    public function verifyToken($mobile=null)
    {
        if ($mobile && strlen($mobile) == 11) {
            $remainingTime = 60;
            return view('customers.verifyToken', compact('mobile', 'remainingTime'));
        } else {
            return redirect(route('customers.verifyMobile'));
        }
    }
}
