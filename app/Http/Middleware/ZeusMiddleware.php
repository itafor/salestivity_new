<?php

namespace App\Http\Middleware;

use Closure;

class ZeusMiddleware
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
        if(auth()->user()->role_id == 3) {

            return $next($request);
        }
        return response()->json([
            'message' => $message
        ]);
    }
}
