<?php

namespace App\Http\Controllers;


use App\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $active = Order::where('status', 1)->get();
        $inactive = Order::where('status', 2)->get();

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

    public function submitOrder(Request $request)
    {
        $mobile = session('mobile');
        if ($mobile && strlen($mobile) == 11) {
            // if user has already ordered, reutrn with proper message
        } else {
            return view('verifyMobile');
        }
    }
}
