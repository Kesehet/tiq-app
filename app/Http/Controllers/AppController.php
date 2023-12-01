<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function postLoginRedirect()
    {
        // Check if the user is a team member
        if (Auth::check() && Auth::user()->isTeamMember()) {
            // Redirect to the dashboard
            return redirect()->route('dashboard');
        }

        // Default redirect for other users
        return redirect()->route('home');
    }
    
    public function home()
    {
        return view('app.home');
    }
}
