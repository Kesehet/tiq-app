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

    public function quizCreate(){
        $user = Auth::user();
        if(!$user->isTeamMember()) {
            return redirect()->route('home');
        }

        return view('dashboard.index',[
            'showPage' => 'quizCreate'
        ]);
    }


    
    public function quizStore(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'questions' => 'required|array',
            'questions.*.text' => 'required|string',
            'questions.*.options' => 'required|array',
            'questions.*.options.*' => 'required|string',
        ]);
    
        $quiz = Quiz::create($data);
    
        foreach ($data['questions'] as $questionData) {
            $question = $quiz->questions()->create(['text' => $questionData['text']]);
            foreach ($questionData['options'] as $optionText) {
                $question->options()->create(['text' => $optionText]);
            }
        }
    
        return redirect()->route('dashboard');
    }
    


}