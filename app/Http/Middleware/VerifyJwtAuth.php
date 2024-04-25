<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyJwtAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
  public function handle($request, Closure $next, $guard = 'api')
    {
        try {
            $user = auth($guard)->parseToken();

            if (!auth($guard)->user()) {
                return response()->json(['error' => 'Token is Invalid'], Response::HTTP_UNAUTHORIZED);
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['error' => 'Token is Invalid'], Response::HTTP_UNAUTHORIZED);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['error' => 'Token is Expired'], Response::HTTP_FORBIDDEN);
            } else {
                return response()->json(['error' => 'Authorization Token not found'], Response::HTTP_NOT_FOUND);
            }
        }
        return $next($request);
    }
}