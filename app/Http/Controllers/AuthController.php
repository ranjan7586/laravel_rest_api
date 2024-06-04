<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function login(Request $req)
    {
        $credentials = $req->only('email', 'password');
        if (Auth::attempt($credentials)) {
            /** @var \App\Models\User $user_details **/
            $user_details = Auth::user();
            $token = $user_details->createToken('Notehelper')->plainTextToken;
            return response()->json(['message' => 'Log in Successful', 'token' => $token, 'user' => $user_details], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 402);
        }
    }
    public function authCheck()
    {
        $user_details = Auth::user();
        return response()->json([
            "message" => "check",
            "header" => $user_details,
            "ok" => true
        ], 200);
    }
}
