<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            // if (Auth::guard($guard)->check()) {
            //     return redirect(RouteServiceProvider::HOME);
            // }
            if( Auth::guard($guard)->check() && Auth::user()->role == 1 && Auth::user()->status == 1){
                return redirect()->route('admin.dashboard');
            }
            elseif( Auth::guard($guard)->check() && Auth::user()->role == 2 && Auth::user()->status == 1){
                return redirect()->route('user.dashboard');
            }
        }

        return $next($request);
    }
}
