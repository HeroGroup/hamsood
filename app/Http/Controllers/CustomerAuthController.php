<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Kavenegar\KavenegarApi;

class CustomerAuthController extends Controller
{
    public function login()
    {
        return view('customers.auth.login');
    }

    public function signup($mobile)
    {
        return view('customers.auth.signup', compact('mobile'));
    }

    public function token($mobile)
    {
        if ($mobile && strlen($mobile) == 11) {
            $remainingTime = 60;
            return view('customers.auth.token', compact('mobile', 'remainingTime'));
        } else {
            return redirect(route('customers.login'));
        }
    }

    public function checkLastLogin($lastLogin)
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
            $customer = Customer::where('mobile', 'like', $request->mobile)->first();
            if ($customer) {
                if(strlen($customer->invitor) == 5) { // already signed up
                    $check = self::checkLastLogin($customer->updated_at);
                    if ($check['status'] < 0) {
                        return $request->has('ajax') ? $this->fail($check['message']) : redirect(route('customers.login'))->with('error', $check['message']);
                    } else {
                        $token = Hash::make(self::sendTokenSms($request->mobile));
                        $customer->update(['token' => $token]);
                        return $request->has('ajax') ? $this->success('request sent') : redirect(route('customers.token',$request->mobile));
                    }
                } else { // not signed up
                    return $request->has('ajax') ? $this->fail('not signed up yet') : redirect(route('customers.signup',$request->mobile));
                }

            } else {
                return $request->has('ajax') ? $this->fail('not signed up yet') : redirect(route('customers.signup',$request->mobile));
            }
        } else {
            return $request->has('ajax') ? $this->fail('invalid mobile') : back()->with('error', 'شماره موبایل نامعتبر');
        }
    }

    public function verifyInvitor(Request $request)
    {
        if($request->mobile && strlen($request->mobile) == 11) {
            if($request->share_code && strlen($request->share_code) == 5) {
                $invitor = Customer::where('share_code','like',$request->share_code)->where('mobile','not like',$request->mobile)->get();
                if ($invitor->count() == 1) {
                    $token = Hash::make(self::sendTokenSms($request->mobile));

                    // check if customer exists
                    $customer = Customer::where('mobile', 'like', $request->mobile)->first();
                    if ($customer) {
                        $customer->update(['invitor' => $request->share_code]);
                    } else {
                        $customer = new Customer([
                            'mobile' => $request->mobile,
                            'token' => $token
                        ]);
                        $customer->save();

                        $base = 23486;
                        $customer->update(['share_code' => $base + ($customer->id*3)]);
                    }

                    return redirect(route('customers.token',$request->mobile));
                } else {
                    return back()->withInput()->with('error', 'کد معرف نامعتبر');
                }
            } else {
                return back()->withInput()->with('error', 'کد معرف نامعتبر');
            }
        } else {
            return redirect(route('customers.login'))->with('error', 'شماره موبایل نامعتبر');
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
                        return redirect(route('customers.token',$mobile))->with('error', 'کد نادرست وارد شده است');
                    }
                } else {
                    return redirect(route('customers.token',$mobile))->with('error', 'کد نامعتبر');
                }
            }
        } else {
            return redirect(route('customers.login'))->with('error', 'شماره موبایل نامعتبر');
        }
    }

    public function logout()
    {
        session(['mobile' => '']);
        return redirect(route('landing'));
    }

}
