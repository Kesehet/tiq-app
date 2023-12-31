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
        return view('app.index', [
            'showPage' => 'home',
            'latestQuizzes' => Quiz::latest()->take(5)->get(),
        ]);
    }

    public function quiz($id)
    {
        $the_quiz = Quiz::find($id);
        $showAnswers = QuizPreference::where('quiz_id', $id)->where('key', 'showAnswers')->get()->first();

        $canChangeAnswers = QuizPreference::where('quiz_id', $id)->where('key', 'canChangeAnswers')->get()->first();
        
        if($canChangeAnswers != null && $canChangeAnswers->count() > 0) {
            $canChangeAnswers = $canChangeAnswers->value;
        }

        if($canChangeAnswers == 0) {
            return redirect()->route('quiz-results', ['quizId' => $id]);
        }

        if($showAnswers != null && $showAnswers->count() > 0) {
            $showAnswers = $showAnswers->value;
        }


        $quizContent = Quiz::readQuizWithQuestionsAndTranslations($the_quiz->id);
        for($index = 0; $index < count($quizContent['questions']); $index++) {
            for($bindex = 0; $bindex < count($quizContent['questions'][$index]['options']); $bindex++){
                if($showAnswers == 0){
                    $quizContent['questions'][$index]['options'][$bindex]['is_correct'] = -1;
                }
                
            }
        }


        

        return view('app.index', [
            'showPage' => 'quiz',
            'quiz' =>  $the_quiz,
            'quizContent' => json_encode($quizContent)
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
    
 
        
        $leaderboard = Answer::with('user', 'option')
            ->where('quiz_id', $quizId)
            ->get()
            ->groupBy('user_id')
            ->map(function ($answers) {
                // Check if the user is loaded and has a name
                $user = $answers->first()->user;
                if ($user) {
                    return [
                        'name' => $user->name,
                        'total_score' => $answers->sum(function ($answer) {
                            return $answer->option ? $answer->option->score : 0;
                        })
                    ];
                }
                return null; // or handle it in a way that suits your application logic
            })
            ->filter() // Remove null values
            ->sortByDesc('total_score')
            ->take(10)
            ->values()
            ->all();
    
            $questionsWithAnswers = Question::with(['options', 'answers' => function ($query) use ($user) {
                $query->where('user_id', $user->id);
            }])->where('quiz_id', $quizId)->get();
    

        

        return view('app.index', [
            'totalScore' => $totalScore,
            'leaderboard' => $leaderboard,
            'correctAnswers' => $correctAnswers,
            'totalQuestions' => $totalQuestions,
            'questionsWithAnswers' => $questionsWithAnswers,
            'showPage' => 'quizResult',
            'quiz' => Quiz::find($quizId),
        ]);
    }


    public function settings(){
        $languages = Language::all(); 
        $prefferedLanguage = UserPreference::where('user_id', auth()->user()->id)->where('key', 'language')->get()->first();
        $reminderTime = $this->getUserPreference('reminder_time');
        $reminderEnabled = $this->getUserPreference('reminder_enabled');
        $user = auth()->user();

        return view('app.index', [
            'showPage' => 'settings',
            'languages' => $languages,
            'prefferedLanguage' => $prefferedLanguage,
            'reminderTime' => $reminderTime,
            'reminderEnabled' => $reminderEnabled,
            'user' => $user
        ]);
    }

    private function getUserPreference($key){
        $user = Auth::user();
        $preference = UserPreference::where('user_id', $user->id)->where('key', $key)->first();
        if ($preference) {
            return $preference->value;
        }
        return null;
    }

    public function savePreferences(Request $request)
    {
        $user = Auth::user();
        $data = $request->only(['language', 'reminder_enabled', 'reminder_time']);
    
        foreach ($data as $key => $value) {
            if ($key == 'reminder_enabled' && !$value) {
                $value = '0'; // Store as '0' if the reminder is disabled
            }
    
            UserPreference::updateOrCreate(
                ['user_id' => $user->id, 'key' => $key],
                ['value' => $value]
            );
        }
    
        return response()->json(['success' => 'Preferences updated successfully.']);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        // Perform search logic, e.g., using Eloquent or a search package
        $quizzes = Quiz::where('title', 'like', '%' . $query . '%')->get();

        return view('app.index', [
            'showPage' => 'search',
            'query' => $query,
            'quizzes' => $quizzes
        ]);
    }

    
    
}
