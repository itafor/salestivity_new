<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class SuperAdminMiddleware
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
        $message = 'You are not a super admin';
        if(auth()->user()->role_id == 1 || Auth::guard('sub_user')->user()->role_id == 1 ) {

            return $next($request);
        }
        return response()->json([
            'message' => $message
        ]);
    }
}

