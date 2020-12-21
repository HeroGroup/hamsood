<?php

namespace App\Http\Controllers;


use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $active = Order::where('status', 1)->orderBy('id', 'desc')->get();
        $inactive = Order::where('status', 2)->orderBy('id', 'desc')->get();

        return view('orders.index', compact('active', 'inactive'));
    }

    public function delivered($order)
    {
        $order = Order::find($order);
        if ($order) {
            $order->update(['status' => 2]);
            return redirect(route('orders.index'))->with('message', 'وضعیت سفارش با موفقیت تغییر یافت')->with('type', 'success');
        } else {
            return redirect(route('orders.index'))->with('message', 'سفارش نامعتبر')->with('type', 'danger');
        }
    }
}
