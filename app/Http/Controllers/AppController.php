<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Quiz;
use App\Models\Answer;
use App\Models\Option;
use App\Models\User;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

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

    public function quizResult($quizId)
    {
        $user = auth()->user();
        $totalScore = 0;
        $correctAnswers = 0;
    
        // Retrieve all answers for the quiz made by the user
        $answers = Answer::where('user_id', $user->id)
                         ->where('quiz_id', $quizId)
                         ->get();
    
        foreach ($answers as $answer) {
            // Assuming each option knows its own score and whether it's correct
            if ($answer->option && $answer->option->is_correct) {
                $correctAnswers++;
                $totalScore += $answer->option->score; // Add score of the correct option
            }
            // Alternatively, if the score is based on the question
            // $totalScore += $answer->question->score; // Add score of the question
        }
    
        $totalQuestions = Question::where('quiz_id', $quizId)->count();
    

        $leaderboard = DB::table('answers')
        ->select('users.name', DB::raw('SUM(answers.score) as total_score'))
        ->join('users', 'answers.user_id', '=', 'users.id')
        ->where('answers.quiz_id', $quizId)
        ->groupBy('answers.user_id')
        ->orderBy('total_score', 'desc')
        ->orderBy('answers.created_at', 'asc')
        ->take(100)
        ->get();
        

        return view('app.index', [
            'totalScore' => $totalScore,
            'leaderboard' => $leaderboard,
            'correctAnswers' => $correctAnswers,
            'totalQuestions' => $totalQuestions,
            'showPage' => 'quizResult',
            'quiz' => Quiz::find($quizId),
        ]);
    }
}
