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
