<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CheckLoginAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
        foreach ($guards as $guard) {
            if (!Auth::guard($guard)->check()) {
                if ($guard == "admin") {
                    return redirect()->route('backend.login_by_auth');
                } else if ($guard == "customer") {
                    return redirect()->route('frontend.sign_in_customer');
                }
            }
        }
        return $next($request);
    }
}