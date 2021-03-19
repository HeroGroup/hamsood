<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

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
        $order->update(['status' => 4]);
        return redirect(route('customers.orders.failed'));
    }

    public function orderProducts($orderId)
    {
        /*if (\request()->customer) {
            $newest = Order::where('customer_id', \request()->customer->id)->max('id');
            $order = Order::find($newest);

            return view('customers.orders.orderProducts', compact('order'));
        } else {
            return redirect(route('verifyMobile'));
        }*/
        $order = Order::find($orderId);
        return view('customers.orders.orderProducts', compact('order'));
    }

    public function orderAddress($orderId)
    {
        /*if (\request()->customer) {
            $newest = Order::where('customer_id', \request()->customer->id)->max('id');
            $order = Order::where('id', $newest)->with('items')->get();

            return view('customers.orders.orderAddress', compact('order'));
        } else {
            return redirect(route('verifyMobile'));
        }*/
        $order = Order::find($orderId);
        return view('customers.orders.orderAddress', compact('order'));
    }

    public function orderBill($orderId)
    {
        /*if (\request()->customer) {
            $newest = Order::where('customer_id', \request()->customer->id)->max('id');
            $order = Order::where('id', $newest)->with('items')->get();

            return view('customers.orders.orderBill', compact('order'));
        } else {
            return redirect(route('verifyMobile'));
        }*/
        $order = Order::find($orderId);
        return view('customers.orders.orderBill', compact('order'));
    }
}
