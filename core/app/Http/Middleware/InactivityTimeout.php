<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class InactivityTimeout
{
    public function handle($request, Closure $next)
    {
        $timeout = 100 * 60; // 30 minutes timeout
        $lastActivity = Session::get('lastActivityTime');

        if ($lastActivity && (time() - $lastActivity) > $timeout) {
            Auth::logout();
            Session::flush();
            return redirect('/user/login')->with('message', 'Your session has expired due to inactivity.');
        }

        Session::put('lastActivityTime', time());
        return $next($request);
    }
}
