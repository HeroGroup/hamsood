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

    public function destroy($customerId)
    {
        try {
            $cart = CustomerCartItem::where('customer_id',$customerId)->delete();
            return redirect(route('carts.index'))->with('message','حذف با موفقیت انجام شد')->with('type','success');
        } catch (\Exception $exception) {
            return redirect(route('carts.index'))->with('message',$exception->getMessage())->with('type','danger');
        }
    }
}
