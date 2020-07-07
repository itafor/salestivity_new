<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminMiddleware
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
        $message = 'You cannot view this page';
        
        if(Auth::user()->role_id === 3 || Auth::user()->role_id == 1
         || Auth::guard('sub_user')->user()->role_id == 3 || Auth::guard('sub_user')->user()->role_id ==1) {

            return $next($request);
        }
        return response()->json([
            'message' => $message
        ]);
    }
}
