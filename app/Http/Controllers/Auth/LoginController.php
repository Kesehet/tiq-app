<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

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
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            // Here you can use the $user object to check if the user exists in your database
            // and log them in, or create a new user if they do not exist

            // Redirect to a desired location after successful authentication
            return redirect()->intended('/post-login');
        } catch (\Exception $e) {
            // Handle exception or failed authentication
            return redirect()->route('login');
        }
    }

    // Additional methods for login logic if needed
}
