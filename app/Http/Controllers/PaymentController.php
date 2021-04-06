<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
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
            Transaction::create([
                'customer_id' => $customerId,
                'transaction_type' => 1,
                'title' => 'افزایش اعتبار',
                'amount' => $request->amount,
            ]);

            $currentBalance = $customer->balance;
            $customer->update(['balance' => $currentBalance+$request->amount]);

        }
        return redirect(route('customers.wallet'));
    }
}
