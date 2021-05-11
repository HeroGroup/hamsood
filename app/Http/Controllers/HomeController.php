<?php

namespace App\Http\Controllers;

use App\AvailableProduct;
use App\AvailableProductDetail;
use App\City;
use App\Customer;
use App\CustomerCartItem;
use App\Neighbourhood;
use App\Notification;
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
        $userBought = 0;
        $orderId = 0;
        $myGroupIsComplete = false;

        $availableProduct = AvailableProduct::find($availableProductId);
        $maximumMembers = $availableProduct->maximum_group_members;
        $numberOfCompletedGroups = intdiv($availableProduct->getOrdersCount(),$maximumMembers);

        $mobile = session('mobile');
        if ($mobile && strlen($mobile) == 11) {
            $customer = Customer::where('mobile', 'like', $mobile)->first();
            if ($customer) {
                $orderItems = DB::table('orders')
                    ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                    ->select('orders.id', 'order_items.weight', 'order_items.nth_buyer', 'order_items.available_product_id')
                    ->where('orders.customer_id',$customer->id)
                    ->whereIn('orders.status',[1,2,11])
                    ->where('order_items.available_product_id',$availableProductId)
                    ->get();

                if($orderItems->count() > 0) {
                    $orderItem = $orderItems->first();
                    $userBought = $orderItem->weight;
                    $orderId = $orderItem->id;
                    $myGroupIsComplete = $orderItem->nth_buyer <= $numberOfCompletedGroups*$maximumMembers ? true : false;
                }
            }
        }

        return [$userBought,$orderId,$myGroupIsComplete,$numberOfCompletedGroups];
    }

    public function checkIfExistsInCart($availableProductId) // in new edition, check if exists in cart
    {
        $userWeight = 0;
        $mobile = session('mobile');
        if ($mobile && strlen($mobile) == 11) {
            $customer = Customer::where('mobile', 'like', $mobile)->first();
            if ($customer) {
                $cartItem = CustomerCartItem::where('customer_id', $customer->id)->where('available_product_id', $availableProductId)->first();
                $userWeight = $cartItem ? $cartItem->weight : 0;
            }
        }

        return $userWeight;
    }

    public static function userCartItemsCount()
    {
        if(session('mobile')) {
            $customer = Customer::where('mobile', 'LIKE', session('mobile'))->first();
            $count = $customer ? CustomerCartItem::where('customer_id', $customer->id)->count() : 0;
            return $count;
        } else {
            return 0;
        }
    }

    public function landing($reference=null)
    {
        $gender = "none";
        $name = "";
        $profileCompleted = false;
        $balance=0;
        $newMessage = 0;
        // session(['mobile' => '09177048781']);
        if(session('mobile')) {
            $customer = Customer::where('mobile', 'LIKE', session('mobile'))->first();
            $gender = $customer->gender;
            $profileCompleted = ($customer->gender && $customer->name) ? true : false;
            $name = $customer->name;
            $balance = $customer->balance;
            $newMessage = Notification::where('customer_id',$customer->id)->count();
        }
        $products = Product::where('is_active',1)->get();
        $result = [];
        $cartItemsCount = $this->userCartItemsCount();
        if ($products->count() > 0) {
            foreach ($products as $product) {
                $availableProduct = AvailableProduct::where('product_id', $product->id)->where('is_active', 1)->first();
                if($availableProduct) {
                    $details = AvailableProductDetail::where('available_product_id', $availableProduct->id)->get();
                    $remaining = $this->getRemainingTime($availableProduct->until_day, $availableProduct->available_until_datetime);

                    $peopleBought = $availableProduct->getOrdersCount() % $availableProduct->maximum_group_members;
                    $userBoughtResult = $this->checkIfUserBought($availableProduct->id);
                    $userWeight = $userBoughtResult[0];
                    $orderId = $userBoughtResult[1];
                    $myGroupIsComplete = $userBoughtResult[2];
                    $numberOfCompletedGroups = $userBoughtResult[3];
                    $userCartWeight = $this->checkIfExistsInCart($availableProduct->id);

                    $nextDiscount = $peopleBought > 1 ? $details[$peopleBought - 1]->discount : $details->min('discount');
                    $lastDiscount = $peopleBought > 1 ? $details[$peopleBought - 2]->discount : $details->min('discount');

                    $item = [
                        'product' => $product,
                        'availableProduct' => $availableProduct,
                        'details' => $details,
                        'remaining' => $remaining,
                        'peopleBought' => $peopleBought,
                        'userWeight' => $userWeight,
                        'orderId' => $orderId,
                        'userCartWeight' => $userCartWeight,
                        'nextDiscount' => $nextDiscount,
                        'lastDiscount' => $lastDiscount,
                        'myGroupIsComplete' => $myGroupIsComplete,
                        'numberOfCompletedGroups' => $numberOfCompletedGroups,
                    ];

                    array_push($result, $item);
                }
            }
            // $referenceId = $userBought ? (Customer::where('mobile', 'like', session('mobile'))->first()->id + 1000) : '';
            return view('customers.landing', compact('result', 'cartItemsCount', 'gender', 'profileCompleted', 'name', 'balance', 'newMessage'));

        } else {
            return view('customers.notActive', compact('gender', 'profileCompleted', 'name', 'balance', 'newMessage'));
        }
    }

    public function productDetailPage($productId)
    {
        $cartItemsCount = $this->userCartItemsCount();
        $product = Product::find($productId);
        $availableProduct = AvailableProduct::where('product_id', $product->id)->where('is_active', 1)->first();
        if($availableProduct) {
            $details = AvailableProductDetail::where('available_product_id', $availableProduct->id)->get();
            $remaining = $this->getRemainingTime($availableProduct->until_day, $availableProduct->available_until_datetime);

            $peopleBought = $availableProduct->getOrdersCount() % $availableProduct->maximum_group_members;
            $userBoughtResult = $this->checkIfUserBought($availableProduct->id);
            $userWeight = $userBoughtResult[0];
            $orderId = $userBoughtResult[1];
            $userCartWeight = $this->checkIfExistsInCart($availableProduct->id);

            $nextDiscount = $peopleBought > 1 ? $details[$peopleBought - 1]->discount : $details->min('discount');
            $lastDiscount = $peopleBought > 1 ? $details[$peopleBought - 2]->discount : $details->min('discount');

            return view('customers.productDetail', compact('product', 'availableProduct', 'details', 'remaining', 'peopleBought', 'userWeight', 'orderId', 'userCartWeight', 'nextDiscount', 'lastDiscount', 'cartItemsCount'));
        } else {
            return view('customers.notActive');
        }
    }

    public static function getRemainingTime($day,$end)
    {
        // $iranStandardTime = 12600;
        $hour = $end - 1;

        $jalali = explode('/', $day);
        $date = strtotime(jalali_to_gregorian($jalali[0], $jalali[1], $jalali[2], '/') . " $hour:59:59");
        return $date - time();
    }

    public function suggest($uid)
    {
        $order = Order::where('uid','LIKE',$uid)->get();
        if($order->count() == 1) {
            $order = $order->first();
            $cartItemsCount = $this->userCartItemsCount();
            $items = [];
            foreach ($order->items as $item) {
                $availableProduct = $item->availableProduct;
                $product = $availableProduct->product;
                $details = $availableProduct->details;
                $remaining = $this->getRemainingTime($availableProduct->until_day, $availableProduct->available_until_datetime);
                $peopleBought = $availableProduct->getOrdersCount() % $availableProduct->maximum_group_members;
                $userBoughtResult = $this->checkIfUserBought($availableProduct->id);
                $userWeight = $userBoughtResult[0];
                $orderId = $userBoughtResult[1];
                $userCartWeight = $this->checkIfExistsInCart($availableProduct->id);
                $nextDiscount = $peopleBought > 1 ? $details[$peopleBought - 1]->discount : $details->min('discount');
                $lastDiscount = $peopleBought > 1 ? $details[$peopleBought - 2]->discount : $details->min('discount');

                $item = [
                    'availableProduct' => $availableProduct,
                    'product' => $product,
                    'remaining' => $remaining,
                    'peopleBought' => $peopleBought,
                    'userWeight' => $userWeight,
                    'orderId' => $orderId,
                    'userCartWeight' => $userCartWeight,
                    'nextDiscount' => $nextDiscount,
                    'lastDiscount' => $lastDiscount
                ];
                array_push($items,$item);
            }
            return view('customers.suggestions.show', compact('order', 'cartItemsCount', 'items'));
        } else {
            return redirect(route('landing'));
        }
    }

    public function verifyMobile()
    {
        return view('customers.verifyMobile');
    }

    public function signup()
    {
        $signup = true;
        return view('customers.verifyMobile',compact('signup'));
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
