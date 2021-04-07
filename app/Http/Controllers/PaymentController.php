<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Transaction;
use Illuminate\Http\Request;
use SaeedVaziry\Payir\Exceptions\SendException;
use SaeedVaziry\Payir\Exceptions\VerifyException;
use SaeedVaziry\Payir\PayirPG;

class PaymentController extends Controller
{
    public function wallet()
    {
        $balance = \request()->customer->id ? Customer::find(\request()->customer->id)->balance : 0;
        return view('customers.payment.wallet', compact('balance'));
    }

    public function transactions()
    {
        $transactions = \request()->customer->id ? Transaction::where('customer_id', \request()->customer->id)->where('tr_status',2)->orderBy('id','desc')->get() : [];
        return view('customers.payment.transactions', compact('transactions'));
    }

    public function pay(Request $request)
    {
        $customerId = \request()->customer->id;
        $customer = Customer::find($customerId);
        if ($customer) {
            $transaction = new Transaction([
                'customer_id' => $customerId,
                'transaction_type' => 1,
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
                    break;
                default:
                    break;
            }
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
            throw $exception;
        }
    }

    public function verify(Request $request)
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
                    'tr_status' => 2 // پرداخت موفق
                ]);

                $customer = Customer::find($transaction->customer_id);
                $currentBalance = $customer->balance;
                $customer->update(['balance' => $currentBalance+($verify['amount']/10)]);


                return redirect($verify['description']);
            } else {
                // $transaction = Transaction::find($this->transaction_id);
                // $transaction->update([
                    // 'token' => $request->token,
                    // 'tr_status' => 1 // انصراف از پرداخت
                // ]);
                return view('notPaid');
            }

        } catch (VerifyException $exception) {
            throw $exception;
        }
    }
}
