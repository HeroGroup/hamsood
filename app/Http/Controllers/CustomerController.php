<?php

namespace App\Http\Controllers;

use App\AvailableProduct;
use App\AvailableProductDetail;
use App\Customer;
use App\CustomerAddress;
use App\CustomerCartItem;
use App\DeliveryTimeFee;
use App\Neighbourhood;
use App\NeighbourhoodDeliveryTimeFee;
use App\Order;
use App\OrderItem;
use App\Product;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Kavenegar\KavenegarApi;

class CustomerController extends Controller
{
    public function loginWithCustomer($mobile)
    {
        session(['mobile' => $mobile]);
        return redirect('/');
    }

    public function index()
    {
        $customers = Customer::orderBy('id', 'desc');

        if(\request()->has('search') && strlen(\request()->search) > 0) {
            $customers = $customers->where('mobile','like','%'.\request()->search.'%')
                ->orWhere('name','like','%'.\request()->search.'%');
        }

        $customers = $customers->get();

        if(\request()->view == "tile")
            return view('admin.customers.indexTile', compact('customers'));
        else
            return view('admin.customers.index', compact('customers'));
    }

    public function customerAddresses($customerId)
    {
        $addresses = CustomerAddress::where('customer_id', $customerId)->get();
        return view('admin.customers.addresses', compact('addresses'));
    }

    public function customerTransactions($customerId)
    {
        $transactions = Transaction::where('customer_id', $customerId)->orderBy('id','desc')->get();
        return view('admin.customers.transactions', compact('transactions'));
    }

    public function generateUID() {
        $rand = "";
        $seed = str_split('abcdefghijklmnopqrstuvwxyz'.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.'0123456789');
        shuffle($seed);
        foreach (array_rand($seed, 5) as $k)
            $rand .= $seed[$k];

        if (Order::where('uid','LIKE',$rand)->count() > 0)
            return $this->generateUID();

        return $rand;
    }

    public function submitOrder()
    {
        try {
            $totalPrice = 0;
            $totalDiscount = 0;
            $order = new Order([
                'uid' => $this->generateUID(),
                'customer_id' => \request()->customer->id,
                'customer_name' => session('customer_name'),
                'discount' => $totalDiscount, // session('discount'),
                'shippment_price' => session('shippment_price'),
                'total_price' => $totalPrice, // session('total_price'),
                'payment_method' => session('payment_method'),
                'neighbourhood_id' => session('neighbourhood_id'),
                'address' => session('address'),
                'delivery_date' => session('date'),
                'delivery_time' => session('time'),
                'status' => 1,
                'extra_description' => session('extra_description')
            ]);
            $order->save();

            $cart = CustomerCartItem::where('customer_id', \request()->customer->id)->get();
            foreach ($cart as $item) {
                // $allOrders = OrderItem::where('available_product_id', $item->available_product_id)->get(['order_id']); // all orders of this available product
                // $submittedOrders = Order::whereIn('id',$allOrders)->where('status',1)->get(['id']); // submitted orders of this available product
                // $buyers = OrderItem::where('available_product_id', $item->available_product_id)->whereIn('order_id',$submittedOrders)->get();

                $availableProduct = AvailableProduct::find($item->available_product_id); // $item->availableProduct();
                $buyers = $availableProduct->getOrdersCount(); // submitted orders only not canceled orders
                $price = $availableProduct->price;
                $details = AvailableProductDetail::where('available_product_id', $availableProduct->id)->get();
                $level = $buyers%$availableProduct->maximum_group_members;
                $discountPercent = $level > 1 ? $details[$level-1]->discount : $details->min('discount');
                $discount = $price * $discountPercent / 100;

                OrderItem::create([
                    'order_id' => $order->id,
                    'available_product_id' => $item->available_product_id,
                    'weight' => $item->weight,
                    'real_price' => $item->real_price,
                    'discount' => $discount,
                    'nth_buyer' => $buyers+1
                ]);

                $totalDiscount = $item->weight*$discount;
                $totalPrice += (($item->real_price - $discount) * $item->weight);
            }

            $order->update([
                'discount' => $totalDiscount,
                'total_price' => $totalPrice
            ]);

            // delete cart
            $deletedRows = CustomerCartItem::where('customer_id', \request()->customer->id)->delete();

           $admins = User::where('send_sms',1)->get();
           foreach ($admins as $admin) {
               $token = $order->id;
               $api = new KavenegarApi('706D534E3771695A3161545A6141765A3367436D53673D3D');
               $result = $api->VerifyLookup($admin->mobile, $token, '', '', 'HamsodOrder');
           }

            $this->clearSession();

            return $order->id;
        } catch(\Exception $exception) {
            dd($exception->getMessage()); // return 0;
        }
    }

    public function clearSession()
    {
        session([
            'product' => '',
            'available_product_id' => '',
            'weight' => '',
            'customer_name' => '',
            'neighbourhood_id' => '',
            'address' => '',
            'date' => '',
            'time' => '',
            'payment_method' => '',
            'discount' => '',
            'shippment_price' => '',
            'shippment_price_for_now' => '',
            'total_price' => '',
            'extra_description' => ''
        ]);
    }

    public function checkIfUserBought($availableProductId, $customer)
    {
        $userBought = 0;
        if ($customer && $availableProductId) {
            $userBought = DB::table('order_items')
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->where('orders.customer_id',$customer)
                ->where('order_items.available_product_id',$availableProductId)
                ->whereIn('orders.status',[1,2])
                ->sum('weight');
        }

        return $userBought;
    }

    public function times($neighbourhood=null)
    {
        if ($neighbourhood > 0) {
            $times = NeighbourhoodDeliveryTimeFee::where('neighbourhood_id', $neighbourhood)->get();

            if ($times->count() > 0) {
                return $times;
            } else {
                $times = DeliveryTimeFee::get();
                return $times;
            }
        } else {
            $times = DeliveryTimeFee::get();
            return $times;
        }
    }

    public function getTime($customerName)
    {
        // get customer default address and make to string
        $customerAddress = CustomerAddress::where('customer_id', \request()->customer->id)->where('is_default',1)->first();
        $address = /*$customerAddress->neighbourhood->city->name . ' ' . $customerAddress->neighbourhood->name . ' ' . */$customerAddress->details;
        $customer = Customer::find(\request()->customer->id);
        $customer->update(['name' => $customerName]);

        session([
            'customer_name' => $customerName,
            'neighbourhood_id' => $customerAddress->neighbourhood_id,
            'address' => $address,
            'date' => jdate('l، d F Y', strtotime("tomorrow"))
        ]);
        $tomorrow = 'فردا - ' . session('date');

        $times = $this->times($customerAddress->neighbourhood_id);
        return view('customers.selectTime', compact('tomorrow', 'times'));
    }

    public function selectTime(Request $request)
    {
        $neighbourhoodTimes = NeighbourhoodDeliveryTimeFee::where('neighbourhood_id', session('neighbourhood_id'))->get();
        $time = $neighbourhoodTimes->count() > 0 ? NeighbourhoodDeliveryTimeFee::find($request->times) : DeliveryTimeFee::find($request->times);
        $cartItems = CustomerCartItem::where('customer_id', \request()->customer->id)->get();
        $realPrice = 0;
        $discount = 0;
        foreach ($cartItems as $cartItem) {
            $realPrice += ( $cartItem->weight * $cartItem->real_price );
            $discount += ( $cartItem->weight * $cartItem->discount );
        }

        $prices = [
            'realPrice' => $realPrice,
            'yourPrice' => $realPrice - $discount,
            'yourProfit' => $discount,
            'shippmentPrice' => $time->delivery_fee,
            'shippmentPriceForNow' => $time->delivery_fee_for_now,
            'yourPayment' => $realPrice - $discount + $time->delivery_fee_for_now
        ];

        session([
            'time' => $time->delivery_start_time.' - '.$time->delivery_end_time,
            'discount' => $discount,
            'total_price' => $prices['yourPrice'],
            'shippment_price' => $time->delivery_fee_for_now
        ]);

        return view('customers.payment', compact('prices'));
    }

    public function confirmBill(Request $request)
    {
        $balance = $request->customer->balance;
        $paymentAmount = $request->paymentAmount;
        return view('customers.finalizeOrder', compact('balance','paymentAmount'));
    }

    public function finalizeOrder(Request $request)
    {
        $customerId = $request->customer->id;
        $paymentMethod = $request->payment_method;
        if($paymentMethod==2 && $request->customer->balance > 0)
            $paymentMethod = 3;

        session([
            'payment_method' => $paymentMethod,
            'extra_description' => $request->extra_description
        ]);
        $customer = Customer::find($customerId);
        $customer->update(['name' => session('customer_name')]);

        $customerCart = CustomerCartItem::where('customer_id',$customerId)->get();
        foreach ($customerCart as $cartItem) {
            if ($this->checkIfUserBought($cartItem->available_product_id, $customerId) >= 4)
                return redirect(route('landing'));

            $remaining = HomeController::getRemainingTime($cartItem->availableProduct->until_day, $cartItem->availableProduct->available_until_datetime);
            if($remaining <= 0)
                return redirect(route('landing'))->with('message','زمان سفارش گیری به اتمام رسید')->with('type', 'danger');
        }

        if ($paymentMethod == 1) { // پرداخت در محل
            $orderId = $this->submitOrder();
            return $orderId > 0 ? redirect(route('customers.orders.products', $orderId)) : redirect(route('landing'));
        } else { // پرداخت اینترنتی
            if($request->amount > 0) {
                $title = "افزایش اعتبار";
                $amount = $request->amount;
                $online_payment_method = $request->online_payment_method;
                $transaction_type = 2; // پرداخت سفارش
                $redirect = route('customers.paid');
                session(['notPaidRedirect' => '/']);
                return view("customers.payment.onlinePaymentParameters", compact('title','amount','online_payment_method','redirect','transaction_type'));
            } else {
                return redirect(route('customers.paid'));
            }
        }
    }

    public function paid()
    {
        $customerId = \request()->customer->id;
        $customer = Customer::find($customerId);

        $orderId = $this->submitOrder();
        $order = Order::find($orderId);

        $toPay = $order->total_price + $order->shippment_price;

        $transaction = new Transaction([
            'customer_id' => $customerId,
            'transaction_sign' => 2, // DEBT
            'transaction_type' => 2, // پرداخت سفارش
            'title' => "پرداخت سفارش $orderId",
            'amount' => $toPay,
            'tr_status' => 1
        ]);
        $transaction->save();

        $currentBalance = $customer->balance;
        $customer->update(['balance' => $currentBalance - $toPay]);
        if ($customer->balance >= 0)
            return redirect(route('customers.orders.products', $orderId));
        else {
            return redirect("/payment/notPaid");
        }
    }

    public function profile()
    {
        if(\request()->customer->id) {
            $customer = Customer::find(\request()->customer->id);
            return view('customers.profile', compact('customer'));
        } else {
            return abort(404);
        }
    }

    public function updateProfile(Request $request)
    {
        if ($request->customer->id) {
            $customer = Customer::find($request->customer->id);
            $customer->update($request->all());
            return redirect(route('customers.profile'));
        } else {
            return abort(404);
        }
    }

}
