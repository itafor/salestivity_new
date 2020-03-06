<?php

namespace App\Http\Middleware;

use Closure;

class GeneralUserMiddleware
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
        $message = 'You are not a user';
        if(auth()->user()->role_id == 2) {

            return $next($request);
        }
        return response()->json([
            'message' => $message
        ]);
    }
}
