<?php

namespace App\Http\Controllers;

// use App\Customer;
// use App\CustomerCartItem;
use App\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /*
    public function userCartItemsCount($ajax=false)
    {
        if(session('mobile')) {
            $customer = Customer::where('mobile', 'LIKE', session('mobile'))->first();
            $count = $customer ? CustomerCartItem::where('customer_id', $customer->id)->count() : 0;
            return $ajax ? $this->success("cart items count", $count) : $count;
        } else {
            return $ajax ? $this->fail("invali customer") : 0;
        }
    }
    */

    public function index()
    {
        $customerId = \request()->customer->id;
        $notifications = Notification::where('customer_id',$customerId)->get();
        $cartItemsCount = HomeController::userCartItemsCount(); // $this->userCartItemsCount();

        return view('customers.notifications.index',compact('notifications','cartItemsCount'));
    }
}
