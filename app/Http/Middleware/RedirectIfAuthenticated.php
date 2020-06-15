<?php

namespace App\Http\Middleware;

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
    public function handle($request, Closure $next, $guard = null)
    {
        if ($guard == "admin" && Auth::guard($guard)->check()) {
            dd($guard);
            return redirect('/admin/home');
        }
        if ($guard == "sub_user" && Auth::guard($guard)->check()) {
            dd($guard);
            return redirect('/home');
        }
        if (Auth::guard($guard)->check()) {
            dd($guard);
            return redirect('/home');
        }
        // if(Auth::guard('sub_user')->check()){
        //     return redirect('/home');
        // }

        // if (Auth::guard($guard)->check()) {
        //     if ('admin' === $guard) {
        //         return redirect('/admin/home');
        //     }
        //     if ('sub_user' === $guard) return redirect('/home');
        //    // if (Auth::guard($guard)->check()) return redirect('/home');
        //     dd($next);

        // }
    

        return $next($request);
    }
}
