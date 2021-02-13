<?php

namespace App\Http\Middleware;

use Closure;

class NotLoggedIn
{
    public function handle($request, Closure $next)
    {
        if (session('mobile') && strlen(session('mobile')) == 11) {
            return redirect(route('landing'));
        }
        return $next($request);
    }
}
