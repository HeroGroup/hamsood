<?php

namespace App\Http\Middleware;

use App\Customer;
use Closure;

class CustomerAuth
{
    public function handle($request, Closure $next)
    {
        if (!session('mobile') || strlen(session('mobile')) != 11) {
            session(['path' => $request->path()]);
            return redirect(route('customers.login'));
        }

        $request->customer = Customer::where('mobile','LIKE',session('mobile'))->first();

        return $next($request);
    }
}
