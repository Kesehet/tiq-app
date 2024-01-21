<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User; // Adjust this based on your user model
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckToken
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) { // Check if user is not authenticated
            $token = $request->cookie('token'); // Replace with your cookie name
            \Log::info($token . ' <-  TOKEN  -> ' . $request->cookie('token'));
            if ($token) {
                try {
                    $user = JWTAuth::setToken($token)->authenticate(); // Validate token and get user
                    auth()->login($user); // Log in the user
                } catch (\Exception $e) {
                    // Handle invalid token (e.g., do nothing or clear the cookie)
                }
            }
        }

        return $next($request);
    }
}
