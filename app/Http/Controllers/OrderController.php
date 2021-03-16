<?php

namespace App\Http\Controllers;


use App\AvailableProduct;
use App\Order;
use App\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index($availableProduct=null)
    {
        $av = AvailableProduct::find($availableProduct);
        $productName = $av ? $av->product->name : "";

        if ($availableProduct) {
            $items = OrderItem::where('available_product_id', $availableProduct)->select('order_id')->distinct()->get();
            $active = Order::whereIn('id', $items)->where('status', 1)->orderBy('id', 'desc')->get();
            $sent = Order::whereIn('id', $items)->where('status', 2)->orderBy('id', 'desc')->get();
            $failed = Order::whereIn('id', $items)->where('status', 3)->orderBy('id', 'desc')->get();
            $canceled = Order::whereIn('id', $items)->where('status', 4)->orderBy('id', 'desc')->get();
        } else {
            $active = Order::where('status', 1)->orderBy('id', 'desc')->get();
            $sent = Order::where('status', 2)->orderBy('id', 'desc')->get();
            $failed = Order::where('status', 3)->orderBy('id', 'desc')->get();
            $canceled = Order::where('status', 4)->orderBy('id', 'desc')->get();
        }

        return view('orders.index', compact('active', 'sent', 'canceled', 'failed', 'availableProduct', 'productName'));
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

    public function failed($order)
    {
        $order = Order::find($order);
        if ($order) {
            $order->update(['status' => 3]);
            return redirect(route('orders.index'))->with('message', 'وضعیت سفارش با موفقیت تغییر یافت')->with('type', 'success');
        } else {
            return redirect(route('orders.index'))->with('message', 'سفارش نامعتبر')->with('type', 'danger');
        }
    }
}
