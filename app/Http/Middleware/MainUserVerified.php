<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class MainUserVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
            if(getActiveGuardType()->user_type == 'users'){
        if(Auth::user()->email_verified_at == null){
             return redirect()->route('mainuser.verify.email');
        }
        return $next($request);
    }
  return $next($request);
    }
}
