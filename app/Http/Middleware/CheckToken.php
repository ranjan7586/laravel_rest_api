<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if (!$token) {
            return response()->json(['message' => 'Token not provided'], 401);
        }
        $tokenRecord = PersonalAccessToken::findToken($token);
        if (!$tokenRecord) {
            return response()->json(['message' => 'Invalid token'], 401);
        }
        $user = $tokenRecord->tokenable;
        Auth::login($user);
        $request['user']=$user;

        // return response()->json([
        //     "message" => "check",
        //     "header" => $request->user,
        //     "ok" => true
        // ], 200);
        return $next($request);
    }
}
