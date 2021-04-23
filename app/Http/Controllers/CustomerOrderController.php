<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AvailableProduct;
use App\Order;
use App\OrderItem;

class CustomerOrderController extends Controller
{
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
        return view('customers.orders.index', compact('orders', 'selected', 'remaining'));
    }

    public function successOrders()
    {
        // status = 2
        $orders = Order::where('customer_id', \request()->customer->id)->where('status', 2)->orderBy('id','DESC')->get();
        $selected = "success";
        return view('customers.orders.index', compact('orders', 'selected'));
    }

    public function failedOrders()
    {
        // status = 3 and 4
        $orders = Order::where('customer_id', \request()->customer->id)->whereIn('status', [3,4])->orderBy('id','DESC')->get();
        $selected = "failed";
        return view('customers.orders.index', compact('orders', 'selected'));
    }

    public function cancelOrder($orderId)
    {
        $order = Order::find($orderId);
        $orderItem = OrderItem::where('order_id',$orderId)->first();
        $product = AvailableProduct::find($orderItem->available_product_id);
        $remaining = HomeController::getRemainingTime($product->until_day, $product->available_until_datetime);

        if($remaining > 0) {
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
