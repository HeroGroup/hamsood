<?php

namespace App\Http\Controllers;

use App\AvailableProduct;
use App\Customer;
use App\Notification;
use App\Order;
use App\OrderItem;
use App\Transaction;
use Illuminate\Http\Request;
use Kavenegar\KavenegarApi;

class OrderController extends Controller
{
    public function payback()
    {
        try {
            require_once app_path('/Helpers/payback.php');
            $result = finalPayback();
            return $this->success($result);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

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

        return view('admin.orders.index', compact('active', 'paid', 'sent', 'canceled', 'failed', 'title'));
    }

    public function delivered($order)
    {
        try {
            $order = Order::find($order);
            if ($order) {
                $order->update(['status' => 2]);

                // SEND SMS TO CUSTOMER
                $mobile = $order->customer->mobile;
                $token = $order->id;
                $api = new KavenegarApi('706D534E3771695A3161545A6141765A3367436D53673D3D');
                $result = $api->VerifyLookup($mobile, $token, '', '', 'HamsodDelivered');

                return redirect(route('orders.index'))->with('message', 'وضعیت سفارش با موفقیت تغییر یافت')->with('type', 'success');
            } else {
                return redirect(route('orders.index'))->with('message', 'سفارش نامعتبر')->with('type', 'danger');
            }
        } catch(\Exception $exception) {
            return redirect(route('orders.index'))->with('message', $exception->getMessage())->with('type', 'danger');
        }
    }

    public function failed($order)
    {
        $order = Order::find($order);
        if ($order) {
            $notificationText = "سفارش شماره $order->id به دلیل نرسیدن به حد نصاب لغو شد.";

            if($order->payment_method != 1) { // پرداخت در محل نباشد
                $amount = $order->total_price+$order->shippment_price;
                Transaction::create([
                    'customer_id' => $order->customer_id,
                    'transaction_sign' => 1, // +
                    'transaction_type' => 3, // برگشت به کیف پول بابت لغو سغارش
                    'title' => "برگشت به کیف پول بابت لغو سغارش شماره $order->id",
                    'amount' => $amount,
                    'tr_status' => 1,
                ]);

                // update customers balance
                $customer = Customer::find($order->customer_id);
                $currentBalance = $customer->balance;
                $customer->update(['balance' => $currentBalance+$amount]);

                $notificationText = "سفارش شماره $order->id به دلیل نرسیدن به حد نصاب لغو شد و مبلغ $amount تومان به کیف پول شما برگشت داده شد.";
            } // end if $order->payment_method != 1

            // save and send notification
            Notification::create([
                'customer_id' => $order->customer_id,
                'notification_title' => 'لغو سفارش',
                'notification_text' => $notificationText,
                'save_inbox' => 1,
            ]);

            $order->update(['status' => 3]);

            return redirect(route('orders.index'))->with('message', 'وضعیت سفارش با موفقیت تغییر یافت')->with('type', 'success');
        } else {
            return redirect(route('orders.index'))->with('message', 'سفارش نامعتبر')->with('type', 'danger');
        }
    }

    public function bill($order)
    {
        $order = Order::find($order);
        return view('admin.orders.bill', compact('order'));
    }
}
