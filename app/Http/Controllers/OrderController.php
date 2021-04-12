<?php

namespace App\Http\Controllers;


use App\AvailableProduct;
use App\Customer;
use App\Order;
use App\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index($availableProduct=null,$customer=null)
    {
        $av = AvailableProduct::find($availableProduct);
        $productName = $av ? $av->product->name : "";
        $title = 'سفارشات ';

        $active = Order::where('status', 1)->orderBy('id', 'desc');
        $paid = Order::where('status', 11)->orderBy('id', 'desc');
        $sent = Order::where('status', 2)->orderBy('id', 'desc');
        $failed = Order::where('status', 3)->orderBy('id', 'desc');
        $canceled = Order::where('status', 4)->orderBy('id', 'desc');

        if($availableProduct > 0) {
            $items = OrderItem::where('available_product_id', $availableProduct)->select('order_id')->distinct()->get();
            $active = $active->whereIn('id', $items);
            $paid = $paid->whereIn('id', $items);
            $sent = $sent->whereIn('id', $items);
            $failed = $failed->whereIn('id', $items);
            $canceled = $canceled->whereIn('id', $items);

            $title .= "گروه #$availableProduct ($productName)";
        }

        if($customer > 0) {
            $active = $active->where('customer_id', $customer);
            $paid = $paid->where('customer_id', $customer);
            $sent = $sent->where('customer_id', $customer);
            $failed = $failed->where('customer_id', $customer);
            $canceled = $canceled->where('customer_id', $customer);

            $customerName = Customer::find($customer)->name;
            $title .= " مشتری $customerName";
        }

        $active = $active->orderBy('id', 'desc')->get();
        $paid = $paid->orderBy('id', 'desc')->get();
        $sent = $sent->orderBy('id', 'desc')->get();
        $failed = $failed->orderBy('id', 'desc')->get();
        $canceled = $canceled->orderBy('id', 'desc')->get();

        return view('orders.index', compact('active', 'paid', 'sent', 'canceled', 'failed', 'title'));
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

    public function bill($order)
    {
        $order = Order::find($order);
        return view('orders.bill', compact('order'));
    }
}
