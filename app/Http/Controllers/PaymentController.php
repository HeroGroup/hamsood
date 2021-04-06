<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function wallet()
    {
        return view('customers.payment.wallet');
    }

    public function transactions()
    {
        return view('customers.payment.transactions');
    }
}
