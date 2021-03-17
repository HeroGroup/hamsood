<?php

namespace App\Http\Controllers;

use App\CustomerCartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = CustomerCartItem::select('customer_id')->distinct()->get();
        return view('admin.carts.index', compact('carts'));
    }
}
