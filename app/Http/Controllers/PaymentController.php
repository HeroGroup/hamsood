<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use App\Transaction;
use Illuminate\Http\Request;
use SaeedVaziry\Payir\Exceptions\SendException;
use SaeedVaziry\Payir\Exceptions\VerifyException;
use SaeedVaziry\Payir\PayirPG;
use Zarinpal\Laravel\Facade\Zarinpal;

class PaymentController extends Controller
{
    public function wallet()
    {
        $balance = \request()->customer->id ? Customer::find(\request()->customer->id)->balance : 0;
        session(['notPaidRedirect' => "/wallet"]);
        return view('customers.payment.wallet', compact('balance'));
    }

    public function transactions()
    {
        $transactions = \request()->customer->id ? Transaction::where('customer_id', \request()->customer->id)->where('tr_status',1)->orderBy('id','desc')->get() : [];
        return view('customers.payment.transactions', compact('transactions'));
    }

    public function pay(Request $request)
    {
        $customerId = \request()->customer->id;
        $customer = Customer::find($customerId);
        if ($customer) {
            $transaction = new Transaction([
                'customer_id' => $customerId,
                'transaction_sign' => 1, // CRED
                'transaction_type' => $request->transaction_type,
                'title' => $request->title,
                'amount' => $request->amount,
                'online_payment_method' => $request->online_payment_method
            ]);
            $transaction->save();

            switch ($request->online_payment_method) {
                case 1: // pay.ir
                    return $this->payir($request->amount, $transaction->id, $request->redirect);
                    break;
                case 2: // zarinpal
                    return $this->payZarinpal($request->amount, $transaction->id, $request->redirect);
                    break;
                default:
                    break;
            }
        }
    }

    public function payZarinpal($amount, $transactionId, $redirectUrl) {
        try {
            $results = Zarinpal::request(
                env('ZARINPAL_CALLBACK'),
                $amount,
                $redirectUrl
            );
    
            $transaction = Transaction::find($transactionId);
            $transaction->update([
                'trans_id' => $results['Authority']
            ]);
            Zarinpal::redirect(); // redirect user to zarinpal
        } catch(Exception $exception) {
            return redirect()->back()->with('message', $exception->getMessage())->with('type', 'danger');
        }
    }

    public function verifyZarinpal(Request $request) {
        try {
            $authority = $request->query('Authority');
            $status = $request->query('Status'); // OK, NOK

            $transaction = Transaction::where('trans_id', $authority)->first();
            $transaction->update([
                'tr_status' => $status == 'OK' ? 1 : 0
            ]);

            if ($status == 'OK') {
                $customer = Customer::find($transaction->customer_id);
                $currentBalance = $customer->balance;
                $customer->update(['balance' => $currentBalance + $transaction->amount]);

                return redirect()->back()->with('message', 'پرداخت موفق')->with('type', 'success');
            } else {
                return redirect()->back()->with('message', 'پرداخت ناموفق')->with('type', 'danger');
            }
        } catch(Exception $exception) {
            return redirect("/payment/notPaid");
        }
    }

    public function payir($amount, $transactionId, $redirectUrl)
    {
        $payir = new PayirPG();
        $payir->amount = $amount*10;
        $payir->factorNumber = $transactionId;
        $payir->description = $redirectUrl;
        // $payir->mobile = '0912XXXXXXX'; // Optional, If you want to show user's saved card numbers in gateway
        // $payir->validCardNumber = '6219860000000000'; // Optional, If you want to limit the payable card

        try {
            $payir->send();

            return redirect($payir->paymentUrl);
        } catch (SendException $exception) {
            return redirect()->back()->with('message', $exception->getMessage())->with('type', 'danger');
        }
    }

    public function verifyPayir(Request $request)
    {
        $payir = new PayirPG();
        $payir->token = $request->token; // Pay.ir returns this token to your redirect url
        try {
            if ($request->status == 1) {
                $verify = $payir->verify(); // returns verify result from pay.ir like (transId, cardNumber, ...)

                $transaction = Transaction::find($verify['factorNumber']);
                $transaction->update([
                    'token' => $request->token,
                    'trans_id' => $verify['transId'],
                    'tr_status' => 1 // پرداخت موفق
                ]);

                $customer = Customer::find($transaction->customer_id);
                $currentBalance = $customer->balance;
                $customer->update(['balance' => $currentBalance+($verify['amount']/10)]);

                return redirect($verify['description']);
            } else {
                return redirect("/payment/notPaid");
            }

        } catch (VerifyException $exception) {
            return redirect()->back()->with('message', $exception->getMessage())->with('type', 'danger');
        }
    }

    public function notPaid()
    {
        $back = session('notPaidRedirect') ?? "";
        session(['notPaidRedirect' => '']);
        return view('notPaid', compact('back'));
    }
}
