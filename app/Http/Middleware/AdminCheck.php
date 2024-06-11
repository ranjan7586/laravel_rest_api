<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user_id = $request->user->id;
        $data = User::find($user_id);
        if ($data->role == "admin")
            return $next($request);
        else {
            return response()->json([
                "message" => "Unauthorized Access",
                "success" => false
            ], 401);
        }
    }
}
