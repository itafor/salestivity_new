<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class SubuserVerified
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
        
        if(getActiveGuardType()->user_type == 'sub_users'){
        if(Auth::guard('sub_user')->user()->email_verified_at == null){
             return redirect()->route('subuser.verify.email');
        }
        return $next($request);
    }
  return $next($request);

}
}
