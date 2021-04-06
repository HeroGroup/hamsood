<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function wallet()
    {
        $balance = 0;
        return view('customers.payment.wallet', compact('balance'));
    }

    public function transactions()
    {
        return view('customers.payment.transactions');
    }

    public function pay(Request $request)
    {
        dd($request);
    }
}
