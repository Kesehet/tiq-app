<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    /**
     * Show the application's login form.
     */
    public function showLoginForm()
    {
        // Logic to show login form
        return view('auth.login');
    }

    /**
     * Redirect to Google for authentication.
     */   
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle response from Google after authentication.
     */
    public function handleGoogleCallback(Request $request)
    {
        //dd($request->all());
        try {
            $googleUser = Socialite::driver('google')->user();
            
    
            $user = User::updateOrCreate(
                [
                    'email' => $googleUser->getEmail(),
                ],
                [
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'password'=>bcrypt($googleUser->getId()),
            ]);
            
            $agent = new \Jenssegers\Agent\Agent;
            $isMobile = $agent->isMobile();
            // get token for user 
            $token = JWTAuth::fromUser($user);
            
            $additionalCode = '?is_mobile=true&code='.$token;
            // Log in the user
            Auth::login($user);
            \Log::info($user->name . ' logged in -> '.$additionalCode);
            // Redirect to a desired location after successful authentication
            return redirect()->intended('/post-login' . ($isMobile ? $additionalCode : ""));

        } catch (\Exception $e) {
            // Handle exception or failed authentication
            \Log::error($e->getMessage());
            // Redirect back to the login page
            return redirect()->route('login');
        }
    }


    public function validateToken(Request $request)
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        }
    
        // Return the user details
        return response()->json(compact('user'));
    }
    
    // Additional methods for login logic if needed
}
