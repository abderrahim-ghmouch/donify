<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('api')->check() && auth('api')->user()->is_banned) {
            // Invalidate the token so they have to login again if unbanned
            try {
                JWTAuth::invalidate(JWTAuth::getToken());
            } catch (\Exception $e) {
                // Token might already be invalid or missing
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Your account has been banned. Please contact support.'
            ], 403);
        }

        return $next($request);
    }
}
