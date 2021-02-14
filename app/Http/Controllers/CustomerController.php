<?php

namespace App\Http\Controllers;

use App\AvailableProduct;
use App\AvailableProductDetail;
use App\Customer;
use App\CustomerAddress;
use App\Neighbourhood;
use App\Order;
use App\OrderItem;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Kavenegar\KavenegarApi;

class CustomerController extends Controller
{
    protected $times = [
        "۸ تا ۱۰ صبح",
        "۱۰ تا ۱۲ ظهر",
        "۱۲ تا ۱۴ بعدارظهر",
        "۱۴ تا ۱۶ عصر",
        "۱۶ تا ۱۸ شب",
        "۱۸ تا ۲۰ شب"
    ];

    public function index()
    {
        $customers = Customer::orderBy('id', 'desc')->get();
        return view('admin.customers.index', compact('customers'));
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
                        return rredirect(route('customers.verifyToken', $mobile))->with('error', 'کد نادرست وارد شده است');
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
                'shippment_price' => 0, // session('shippment_price'),
                'total_price' => session('total_price'),
                'payment_method' => session('payment_method'),
                'neighbourhood_id' => session('neighbourhood_id'),
                'address' => session('address'),
                'delivery_date' => session('date'),
                'delivery_time' => session('time'),
                'status' => 1
            ]);
            $order->save();

            OrderItem::create([
                'order_id' => $order->id,
                'available_product_id' => session('available_product_id'),
                'weight' => session('weight')
            ]);

            $this->clearSession();

            return $order->id;
        } catch(Exception $exception) {
            return 0;
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
            'total_price' => ''
        ]);
    }

    public function checkIfUserBought($availableProductId, $customer)
    {
        $userBought = false;
        if ($customer && $availableProductId) {
            $items = OrderItem::where('available_product_id', $availableProductId)->select('order_id')->distinct()->get();
            if (Order::where('customer_id', $customer)->whereIn('id', $items)->count() > 0)
                $userBought = true;
        } else { // customer or product is not valid
            $userBought = true;
        }

        return $userBought;
    }

    public function getOrderProduct($product)
    {
        $availableProduct = AvailableProduct::where('product_id', $product)->where('is_active', 1)->first();
        $details = AvailableProductDetail::where('available_product_id', $availableProduct->id)->get();
        $peopleBought = $availableProduct->getOrdersCount();
        $nextDiscount = $peopleBought > 1 ? $details[$peopleBought-1]->discount : $details->min('discount');

        session([
            'product' => $product,
            'available_product_id' => $availableProduct->id,
            'real_price' => $availableProduct->price,
            'discount' => $nextDiscount
        ]);

        $product = Product::find($product);
        return view('customers.orderProduct',compact('availableProduct', 'product', 'nextDiscount'));
    }

    public function orderFirstStep($weight)
    {
        $realPrice = session('real_price');
        $discount = $realPrice * (session('discount')/100);
        $totalPrice = $weight * ($realPrice - $discount);

        session([
            'weight' => $weight,
            'discount' => $weight * $discount,
            'total_price' => $totalPrice
        ]);

        return redirect(route('customers.selectAddress'));
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

        $times = $this->times;
        return view('customers.selectTime', compact('tomorrow', 'times'));
    }

    public function selectTime(Request $request)
    {
        session(['time' => $this->times[$request->times]]);
        return view('customers.payment');
    }

    public function selectPaymentMethod(Request $request)
    {
        $prices = [
            'realPrice' => session('weight') * session('real_price'),
            'yourPrice' => session('total_price'),
            'yourProfit' => session('weight') * session('real_price') - session('total_price'),
            'shippmentPrice' => 5000,
            'yourPayment' => session('total_price')
        ];

        session([
            'payment_method' => $request->payment_method,
            'shippment_price' => $prices['shippmentPrice'],
        ]);
        return view('customers.finalizeOrder', compact('prices'));
    }

    public function finializeOrder()
    {
        // dd(session()->all());
        // store customer name in customers
        $customer = Customer::find(\request()->customer->id);
        $customer->update(['name' => session('customer_name')]);

        // store order with fields available product id , weight, date, time, payment_method, customer_name, address from session
        if ($this->checkIfUserBought(session('available_product_id'), \request()->customer->id)) {
            return redirect(route('customers.orders'))->with('message', 'این خرید را قبلا انجام داده اید.')->with('type', 'danger');
        } else {
            $orderId = $this->submitOrder();
            return redirect(route('customers.orders.products', $orderId));
        }
    }

    public function logout()
    {
        session(['mobile' => '']);
        return redirect(route('landing'));
    }
}
