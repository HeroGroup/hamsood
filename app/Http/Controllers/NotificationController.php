<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $customerId = \request()->customer->id;
        $notifications = Notification::where('customer_id',$customerId)->get();

        return view('customers.notifications.index',compact('notifications'));
    }
}
