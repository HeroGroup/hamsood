<?php

namespace App\Http\Controllers;

use App\Customer;
// use App\CustomerCartItem;
use App\Transaction;
use Illuminate\Http\Request;
use App\AvailableProduct;
use App\Order;
use App\OrderItem;

class CustomerOrderController extends Controller
{
    /*
    public function userCartItemsCount($ajax=false)
    {
        if(session('mobile')) {
            $customer = Customer::where('mobile', 'LIKE', session('mobile'))->first();
            $count = $customer ? CustomerCartItem::where('customer_id', $customer->id)->count() : 0;
            return $ajax ? $this->success("cart items count", $count) : $count;
        } else {
            return $ajax ? $this->fail("invali customer") : 0;
        }
    }
    */

    public function index()
    {
        $newest = Order::where('customer_id', \request()->customer->id)->max('id');
        if($newest && $newest > 0)
            return redirect(route('customers.orders.products', $newest));
        else
            return view('customers.orders.index');
    }

    public function currentOrders()
    {
        // status = 1
        $orders = Order::where('customer_id', \request()->customer->id)->where('status', 1)->orderBy('id','DESC')->get();
        $selected = "current";
        if ($orders->count() > 0) {
            $day = $orders->first()->items->first()->availableProduct->until_day;
            $end = $orders->first()->items->first()->availableProduct->available_until_datetime;
            $remaining = HomeController::getRemainingTime($day, $end);
        } else {
            $remaining = 0;
        }
        $cartItemsCount = HomeController::userCartItemsCount(); // $this->userCartItemsCount();
        return view('customers.orders.index', compact('orders', 'selected', 'remaining','cartItemsCount'));
    }

    public function successOrders()
    {
        // status = 2
        $orders = Order::where('customer_id', \request()->customer->id)->where('status', 2)->orderBy('id','DESC')->get();
        $selected = "success";
        $cartItemsCount = HomeController::userCartItemsCount(); // $this->userCartItemsCount();
        return view('customers.orders.index', compact('orders', 'selected','cartItemsCount'));
    }

    public function failedOrders()
    {
        // status = 3 and 4
        $orders = Order::where('customer_id', \request()->customer->id)->whereIn('status', [3,4])->orderBy('id','DESC')->get();
        $selected = "failed";
        $cartItemsCount = HomeController::userCartItemsCount(); // $this->userCartItemsCount();
        return view('customers.orders.index', compact('orders', 'selected','cartItemsCount'));
    }

    public function cancelOrder($orderId)
    {
        $order = Order::find($orderId);
        $orderItem = OrderItem::where('order_id',$orderId)->first();
        $product = AvailableProduct::find($orderItem->available_product_id);
        $remaining = HomeController::getRemainingTime($product->until_day, $product->available_until_datetime);

        if($remaining > 0) {
            if($order->payment_method == 2) { // پرداخت اینترنتی
                $amount = $order->total_price+$order->shippment_price;
                Transaction::create([
                    'customer_id' => $order->customer_id,
                    'transaction_sign' => 1,
                    'transaction_type' => 3,
                    'title' => "برگشت به کیف پول بابت لغو سغارش شماره $order->id",
                    'amount' => $amount,
                    'tr_status' => 1,
                ]);

                // update customers balance
                $customer = Customer::find($order->customer_id);
                $curretBalance = $customer->balance;
                $customer->update(['balance' => $curretBalance+$amount]);
            }

            // loop on order items
            $items = $order->items();
            foreach ($items as $item) {
                $nth_buyer = $item->nth_buyer;
                if($nth_buyer>0) {
                    $nextItems = OrderItem::where('available_product_id', $item->available_product_id)->where('nth_buyer', '>', $nth_buyer)->get();
                    foreach ($nextItems as $nextItem) {
                        $nb = $nextItem->nth_buyer;
                        $nextItem->update(['nth_buyer' => $nb-1]);
                    }
                }
            }

            $order->update(['status' => 4]);
            return redirect(route('customers.orders.failed'));
        } else {
            return redirect()->back()->with("message","به دلیل پایان زمان سفارش گیری امکان لغو وجود ندارد.")->with("type","error");
        }
    }

    public function orderProducts($orderId)
    {
        $order = Order::find($orderId);
        return view('customers.orders.orderProducts', compact('order'));
    }

    public function orderAddress($orderId)
    {
        $order = Order::find($orderId);
        return view('customers.orders.orderAddress', compact('order'));
    }

    public function orderBill($orderId)
    {
        $order = Order::find($orderId);
        return view('customers.orders.orderBill', compact('order'));
    }
}
