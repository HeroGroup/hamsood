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

            $remainingTime = 60;
            return view('customers.verifyToken', compact('remainingTime'));
        } else {
            return redirect('/verifyMobile')->with('error', 'شماره موبایل نامعتبر');
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
                        return redirect(route('customers.landing'));
                    } else {
                        return redirect('/verifyToken')->with('error', 'کد نادرست وارد شده است');
                    }
                } else {
                    return redirect('/verifyToken')->with('error', 'کد نامعتبر');
                }
            }
        } else {
            return redirect('/verifyMobile')->with('error', 'شماره موبایل نامعتبر');
        }
    }

    public function submitOrder($customer)
    {
        $product = Product::where('is_active', 1)->first();
        if ($product) {
            $availableProduct = AvailableProduct::where('product_id', $product->id)->where('is_active', 1)->first();

            // if not already bought
            if (!$this->checkIfUserBought($availableProduct->id, $customer)) {

                /*========== newly added ==========*/
                $peopleBought = OrderItem::where('available_product_id', $availableProduct->id)->count();
                $level = $peopleBought % $availableProduct->maximum_group_members;
                $discount = AvailableProductDetail::where('available_product_id', $availableProduct->id)->where('level', $level)->first();
                /*========== newly added ==========*/

                $order = new Order([
                    'customer_id' => $customer,
                    'discount' => $discount ? $discount->discount : 0,
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
        if ($customer && $availableProductId) {
            $items = OrderItem::where('available_product_id', $availableProductId)->select('order_id')->distinct()->get();
            if (Order::where('customer_id', $customer)->whereIn('id', $items)->count() > 0)
                $userBought = true;
        }

        return $userBought;
    }

    public function addresses()
    {
        $addresses = CustomerAddress::all();
        return view('customers.addresses', compact('addresses'));
    }

    public function selectNeighbourhood()
    {
        return view('customers.neighbourhood');
    }

    public function getNeighbourhoods($city, $keyword=null)
    {
        $neighbourhoods = Neighbourhood::where('city_id',$city);
        if ($keyword)
            $neighbourhoods = $neighbourhoods->where('name','LIKE',"%$keyword%")->select('id','name')->get();
        else
            $neighbourhoods = $neighbourhoods->select('id','name')->get();

        return response()->json($neighbourhoods);
    }

    public function postNeighbourhood($neighbourhood)
    {
        $neighbourhood = Neighbourhood::find($neighbourhood);
        return view('customers.addressDetails', compact('neighbourhood'));
    }

    public function postAddressDetail(Request $request)
    {
        dd($request);
    }
}
