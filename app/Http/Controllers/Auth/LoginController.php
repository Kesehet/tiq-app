<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
    // public function handleGoogleCallback(Request $request)
    // {
    //     //dd($request->all());
    //     try {
    //         $googleUser = Socialite::driver('google')->user();
            
    
    //         $user = User::updateOrCreate(
    //             [
    //                 'email' => $googleUser->getEmail(),
    //             ],
    //             [
    //             'name' => $googleUser->getName(),
    //             'email' => $googleUser->getEmail(),
    //             'password'=>bcrypt($googleUser->getId()),
    //         ]);
        
    
    //         // Log in the user
    //         Auth::login($user);
    
    //         // Redirect to a desired location after successful authentication
    //         return redirect()->intended('/post-login');




    //     } catch (\Exception $e) {
    //         // Handle exception or failed authentication
            
    //         return redirect()->route('login');
    //     }
    // }
    
    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::updateOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt($googleUser->getId()),
                ]
            );
        
            // Log in the user
            Auth::login($user);
    
            // Generate a token or a success indicator for your mobile app
            $token = $user->createToken('YourAppToken')->accessToken;
            // Redirect to your custom scheme with the token
            return redirect("tiqapp://login/google/callback?token=$token");
    
        } catch (\Exception $e) {
            // Handle exception or failed authentication
            return redirect()->route('login');
        }
    }

    public function exchangeToken(Request $request)
    {
        $code = $request->code;
        // Exchange the code for an access token and authenticate the user
    }
    // Additional methods for login logic if needed
}
