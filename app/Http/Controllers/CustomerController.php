<?php

namespace App\Http\Controllers;

use App\Customer;
use App\CustomerAddress;
use App\CustomerCartItem;
use App\DeliveryTimeFee;
use App\Neighbourhood;
use App\NeighbourhoodDeliveryTimeFee;
use App\Order;
use App\OrderItem;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Kavenegar\KavenegarApi;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('id', 'desc')->get();
        return view('admin.customers.index', compact('customers'));
    }

    public function customerAddresses($customerId)
    {
        $addresses = CustomerAddress::where('customer_id', $customerId)->get();
        return view('admin.customers.addresses', compact('addresses'));
    }

    public static function checkLastLogin($lastLogin)
    {
        $seconds = 120;
        $lastLoginAttempt = new \DateTime($lastLogin);
        $nextTry = $lastLoginAttempt->add(new \DateInterval('PT' . $seconds . 'S'));
        $now = new \DateTime('now');
        $interval = $nextTry->diff($now);
        if ($interval->f < 0)
            return ['status' => -1, 'message' => 'لطفا ' . ($interval->i * 60 + $interval->s) . ' ثانیه دیگر مجددا تلاش کنید.'];
        else
            return ['status' => 1];
    }


    public static function sendTokenSms($mobile)
    {
        $token = rand(1000, 9999);
        $api = new KavenegarApi('706D534E3771695A3161545A6141765A3367436D53673D3D');
        $result = $api->VerifyLookup($mobile, $token, '', '', 'hamsodverify');
        return $token;
    }

    public function verifyMobile(Request $request)
    {
        if ($request->mobile && strlen($request->mobile) == 11) {
            // check if customer exists
            $customerExists = Customer::where('mobile', 'like', $request->mobile)->count();
            if ($customerExists) {
                $customer = Customer::where('mobile', 'like', $request->mobile)->first();
                $check = self::checkLastLogin($customer->updated_at);
                if ($check['status'] < 0) {
                    return redirect(route('customers.verifyMobile'))->with('error', $check['message']);
                } else {
                    $token = Hash::make(self::sendTokenSms($request->mobile));
                    $customer->update(['token' => $token]);
                }
            } else {
                $token = Hash::make(self::sendTokenSms($request->mobile));
                $customer = new Customer([
                    'mobile' => $request->mobile,
                    'token' => $token
                ]);
                $customer->save();
            }

            return $request->has('ajax') ? $this->success('request sent') : redirect(route('customers.verifyToken', $request->mobile));
        } else {
            return $request->has('ajax') ? $this->fail('invalid mobile') : redirect(route('customers.verifyMobile'))->with('error', 'شماره موبایل نامعتبر');
        }
    }

    public function verifyToken(Request $request)
    {
        $mobile = $request->mobile;
        if ($mobile && strlen($mobile) == 11) {
            $customer = Customer::where('mobile', 'like', $mobile)->first();

            if ($customer) {
                $tokenFromDatabase = $customer->token;
                $token = $request->token;
                if ($token) {
                    if (Hash::check(strval($token), $tokenFromDatabase)) {
                        $path = session('path');
                        session(['mobile' => $mobile, 'path' => '']);
                        return redirect($path ?? route('landing'));
                    } else {
                        return redirect(route('customers.verifyToken', $mobile))->with('error', 'کد نادرست وارد شده است');
                    }
                } else {
                    return redirect(route('customers.verifyToken', $mobile))->with('error', 'کد نامعتبر');
                }
            }
        } else {
            return redirect(route('customers.verifyMobile'))->with('error', 'شماره موبایل نامعتبر');
        }
    }

    public function submitOrder()
    {
        try {
            $order = new Order([
                'customer_id' => \request()->customer->id,
                'customer_name' => session('customer_name'),
                'discount' => session('discount'),
                'shippment_price' => session('shippment_price_for_now'),
                'total_price' => session('total_price'),
                'payment_method' => session('payment_method'),
                'neighbourhood_id' => session('neighbourhood_id'),
                'address' => session('address'),
                'delivery_date' => session('date'),
                'delivery_time' => session('time'),
                'status' => 1
            ]);
            $order->save();

            $cart = CustomerCartItem::where('customer_id', \request()->customer->id)->get();
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'available_product_id' => $item->available_product_id,
                    'weight' => $item->weight
                ]);
            }

            // delete cart
            $deletedRows = CustomerCartItem::where('customer_id', \request()->customer->id)->delete();

           /*$admins = User::where('send_sms',1)->get();
           foreach ($admins as $admin) {
               $token = session('available_product_id');
               $api = new KavenegarApi('706D534E3771695A3161545A6141765A3367436D53673D3D');
               $result = $api->VerifyLookup($admin->mobile, $token, '', '', 'HamsodOrder');
           }*/

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
            'total_price' => ''
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
            $realPrice += $cartItem->weight*$cartItem->real_price;
            $discount += $cartItem->weight*$cartItem->discount;
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
            'payment_method' => $request->payment_method,
            'discount' => $discount,
            'total_price' => $prices['yourPrice'],
            'shippment_price' => $time->delivery_fee_for_now
        ]);

        return view('customers.payment', compact('prices'));
    }

    public function finalizeOrder(Request $request)
    {
        session(['payment_method' => $request->payment_method]);
        $customer = Customer::find(\request()->customer->id);
        $customer->update(['name' => session('customer_name')]);

        $customerCart = CustomerCartItem::where('customer_id',\request()->customer->id)->get();
        foreach ($customerCart as $cartItem)
            if ($this->checkIfUserBought($cartItem->available_product_id, \request()->customer->id) >= 4)
                return redirect(route('landing'));

        $orderId = $this->submitOrder();
        return $orderId > 0 ? redirect(route('customers.orders.products', $orderId)) : redirect(route('landing'));
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

    public function logout()
    {
        session(['mobile' => '']);
        return redirect(route('landing'));
    }
}
