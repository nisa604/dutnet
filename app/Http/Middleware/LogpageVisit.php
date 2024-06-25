<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\M_log_durasi;
use DateTime;

class LogPageVisit
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check()) {
            $loginTime = session('login_time') ?? new DateTime();
            $logoutTime = null;
            $url = $request->fullUrl();

            M_log_durasi::logPageVisit($url, $loginTime, $logoutTime);
        }

        return $response;
    }
}