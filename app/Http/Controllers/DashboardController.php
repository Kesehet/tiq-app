<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Quiz;
use App\Models\Answer;
use App\Models\Option;
use App\Models\User;
use App\Models\Question;
use App\Models\Language;
use App\Models\UserPreference;
use Illuminate\Support\Facades\DB;
use App\Models\QuizPreference;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        
    }
    public function home()
    {
        $user = Auth::user();
        if(!$user->isTeamMember()) {
            return redirect()->route('home');
        }




        return view('dashboard.index', [
            'showPage' => 'home',
            'latestQuizzes' => Quiz::latest()->take(5)->get(),
        ]);
    }

    public function quizzes(){
        $user = Auth::user();
        if(!$user->isTeamMember()) {
            return redirect()->route('home');
        }

        return view('dashboard.index',[
            'showPage' => 'quizAll',
            'quizzes' => Quiz::all()
        ]);
    }


    public function quizCreate(Request $request){
        $user = Auth::user();
        if(!$user->isTeamMember()) {
            return redirect()->route('home');
        }
    
        $quizzes = null;
        if ($request->has('q')) {
            $searchQuery = $request->input('q');
            // Search for quizzes by name. Adjust the query as per your database and requirements
            $quizzes = Quiz::where('title', 'LIKE', '%' . $searchQuery . '%')->get();
        }
        else {
            // get latest 50 quizzes
            $quizzes = Quiz::latest()->take(50)->get();
        }
    
        return view('dashboard.index', [
            'showPage' => 'quizCreate',
            'quizzes' => $quizzes // Pass the quizzes to the view
        ]);
    }


    public function quizStore(Request $request)
    {
        $user = Auth::user();
        if(!$user->isTeamMember()) {
            return redirect()->route('home');
        }

        $data = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
        ]);

        $quiz = Quiz::create($data);

        // Redirect to a specific route (e.g., dashboard) or the newly created quiz
        return redirect()->route('dashboard');
    }

    


}