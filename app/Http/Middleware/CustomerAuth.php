<?php

namespace App\Http\Middleware;

use Closure;

class CustomerAuth
{
    public function handle($request, Closure $next)
    {

        if (!session('mobile') || strlen(session('mobile')) != 11) {
            return redirect('verifyMobile');
        }

        return $next($request);
    }
}
