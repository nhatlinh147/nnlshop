<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ($guard == "admin" && Auth::guard($guard)->check()) {
                    return redirect()->route('backend.dashboard_finance');
                } else if ($guard == "customer" && Auth::guard($guard)->check()) {
                    return redirect()->route('frontend.index');
                }
            }
        }
        return $next($request);
    }
}