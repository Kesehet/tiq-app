<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Quiz;

class AppController extends Controller
{
    // Construct 
    public function __construct()
    {
        $this->middleware('auth');

        // Check if the user is a team member
        if (Auth::check() && Auth::user()->isTeamMember()) {
            // Redirect to the dashboard
            return redirect()->route('dashboard');
        }

    }

    public function postLoginRedirect()
    {


        // Default redirect for other users
        return redirect()->route('home');
    }
    
    public function home()
    {
        return view('app.index', [
            'showPage' => 'home',
            'latestQuizzes' => Quiz::latest()->take(5)->get(),
        ]);
    }

    public function quiz($id)
    {

        return view('app.index', [
            'showPage' => 'quiz',
            'quiz' => Quiz::find($id),
        ]);
    }
}
