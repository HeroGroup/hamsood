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
    protected $amount;
    protected $transaction_id;
    protected $customerId;
    protected $redirect;

    public function wallet()
    {
        $balance = \request()->customer->id ? Customer::find(\request()->customer->id)->balance : 0;
        return view('customers.payment.wallet', compact('balance'));
    }

    public function transactions()
    {
        $transactions = \request()->customer->id ? Transaction::where('customer_id', \request()->customer->id)->orderBy('id','desc')->get() : [];
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
            ]);
            $transaction->save();

            $this->transaction_id = $transaction->id;
            $this->amount = $transaction->amount;
            $this->customerId = $transaction->customer_id;
            $this->redirect = $request->redirect;

            switch ($request->online_payment_method) {
                case 1: // pay.ir
                    return $this->payir();
                    break;
                case 2: // zarinpal
                    break;
                default:
                    break;
            }
        }
    }

    public function payir()
    {
        $payir = new PayirPG();
        $payir->amount = $this->amount*10; // Required, Amount
        // $payir->factorNumber = 'Factor-Number'; // Optional
        // $payir->description = 'Some Description'; // Optional
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
            $verify = $payir->verify(); // returns verify result from pay.ir like (transId, cardNumber, ...)

            dd($verify);
            // $customer = Customer::find($this->customerId);
            // $currentBalance = $customer->balance;
            // $customer->update(['balance' => $currentBalance+$this->amount]);

            // $transaction = Transaction::find($this->transaction_id);
            // $transaction->update(['token' => $request->token]);

            // return redirect($this->redirect);
        } catch (VerifyException $exception) {
            throw $exception;
        }
    }
}
