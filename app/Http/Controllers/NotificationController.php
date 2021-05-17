<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $customerId = \request()->customer->id;
        $notifications = Notification::where('customer_id',$customerId)->orderBy('id','DESC')->get();

        $current_date_time = Carbon::now()->toDateTimeString();
        Notification::where('customer_id',$customerId)
            ->whereNull('viewed_at')
            ->update(['viewed_at' => $current_date_time]);

        $cartItemsCount = HomeController::userCartItemsCount();

        return view('customers.notifications.index',compact('notifications','cartItemsCount'));
    }
}
