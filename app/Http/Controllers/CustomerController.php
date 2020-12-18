<?php

namespace App\Http\Controllers;

use App\AvailableProduct;
use App\Customer;
use App\Order;
use App\OrderItem;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Kavenegar\KavenegarApi;

class CustomerController extends Controller
{
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
        $token = 1234;// rand(1000, 9999);
        // $api = new KavenegarApi('706D534E3771695A3161545A6141765A3367436D53673D3D');
        // $result = $api->VerifyLookup($mobile, $token, '', '', 'hamsodverify');
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
                    return redirect('/verifyMobile')->with('error', $check['message']);
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

            session(['mobile' => $request->mobile]);

            return view('verifyToken');
        } else {
            return redirect(route('verifyMobile'))->with('error', 'شماره موبایل نامعتبر');
        }
    }

    public function verifyToken(Request $request)
    {
        $mobile = session('mobile');
        if ($mobile && strlen($mobile) == 11) {
            $customer = Customer::where('mobile', 'like', $mobile)->first();

            if ($customer) {
                $tokenFromDatabase = $customer->token;
                $token = $request->token;
                if ($token) {
                    if (Hash::check(strval($token), $tokenFromDatabase)) {
                        $this->submitOrder($customer->id);
                        return redirect(route('landing'));
                    } else {
                        return redirect(route('verifyToken'))->with('error', 'کد نادرست وارد شده است');
                    }
                } else {
                    return redirect(route('verifyToken'))->with('error', 'کد نامعتبر');
                }
            }
        } else {
            return redirect(route('verifyMobile'))->with('error', 'شماره موبایل نامعتبر');
        }
    }

    public function submitOrder($customer)
    {
        $product = Product::where('is_active', 1)->first();
        if ($product) {
            $availableProduct = AvailableProduct::where('product_id', $product->id)->where('is_active', 1)->first();

            // if not already bought
            if (!$this->checkIfUserBought($availableProduct->id, $customer)) {
                $order = new Order([
                    'customer_id' => $customer,
                    'status' => 1
                ]);
                $order->save();

                OrderItem::create([
                    'order_id' => $order->id,
                    'available_product_id' => $availableProduct->id
                ]);
            }
        }
    }


    public function checkIfUserBought($availableProductId, $customer)
    {
        $userBought = false;
        if ($customer) {
            $order = Order::where('customer_id', $customer)->where('status', 1)->first();
            if ($order) {
                $items = OrderItem::where('order_id', $order->id)->where('available_product_id', $availableProductId)->count();
                if ($items > 0)
                    $userBought = true;
            }
        }
        return $userBought;
    }
}
