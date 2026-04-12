<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request):
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (auth('api')->check() && auth('api')->user()->role === 'admin') {
            return $next($request);
        }
        else {

        return response()->json(['message'=>'unauthorized admin'],403,['status'=>'error']);
          }
    }
}
