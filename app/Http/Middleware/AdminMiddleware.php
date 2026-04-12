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
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Check if user is logged in AND has admin role
        if (auth('api')->check() && auth('api')->user()->role === 'admin') {
            return $next($request);
        }

        // 2. Return proper JSON response for API
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized. Admin access required.'
        ], 403);
    }
}
