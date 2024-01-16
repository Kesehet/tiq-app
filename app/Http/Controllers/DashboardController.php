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
use App\Models\Translation;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }
    public function home()
    {
        $user = Auth::user();
        if(!$user->isTeamMember())
         {
            return redirect()->route('home');
        }

         {
         $quizcount = Quiz::all()->count();
         $questioncount = Question::all()->count();

          $usercount = User::all()->count();




         return view('dashboard.index',
         [
         'showPage'  => 'home',
         'quizcount' => $quizcount,
         'questioncount'  => $questioncount,
         'usercount'     => $usercount,


         ]);


         }


}


    public function quizzes(Request $request){
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

        return view('dashboard.index',[
            'showPage' => 'quizAll',
            'quizzes' => $quizzes
        ]);
    }


    public function quizCreate(Request $request){
        $user = Auth::user();
        if(!$user->isTeamMember()) {
            return redirect()->route('home');
        }


        return view('dashboard.index', [
            'showPage' => 'quizCreate',
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
            'user_id' => 'required',
            'add_question' => 'required',
        ]);

        $quiz = Quiz::create($data);

        if($request->add_question == 1) {
            return redirect()->route('dashboard.question.create', ['quiz_id' => $quiz->id]);
        }
        return redirect()->route('dashboard.quizzes');
    }



    public function questions(Request $request){
        $user = Auth::user();
        if(!$user->isTeamMember()) {
            return redirect()->route('home');
        }

        $questions = null;
        if ($request->has('q')) {
            $searchQuery = $request->input('q');
            // Search for quizzes by name. Adjust the query as per your database and requirements
            $questions = Question::where('question_text', 'LIKE', '%' . $searchQuery . '%')->get();
        }
        else {
            // get latest 50 quizzes
            $questions = Question::latest()->take(50)->get();
        }
        foreach($questions as $question) {
            $question->options = Option::where('question_id', $question->id)->get();
            $question->answers = Answer::where('question_id', $question->id)->get();
            $question->translations = Translation::where('question_id', $question->id)->get();
        }

        return view('dashboard.index',[
            'showPage' => 'questionAll',
            'questions' => $questions
        ]);
    }


    public function questionCreate(Request $request){
        $user = Auth::user();
        if(!$user->isTeamMember()) {
            return redirect()->route('home');
        }

        $quiz = Quiz::find($request->quiz_id);

        if($quiz == null) {
            // get the quiz that was recently added ...
            $quiz = Quiz::all()->last();
        }

        return view('dashboard.index', [
            'showPage' => 'questionCreate',
            'quiz_selected' => $quiz,
            'quizzes' => Quiz::all(),
            'languages' => Language::all(),
        ]);
    }


    public function questionStore(Request $request)
    {
        $user = Auth::user();
        if(!$user->isTeamMember()) {
            return redirect()->route('home');
        }

        $data = $request->validate([
            'quiz_id' => 'required',
            'question_text' => 'required|max:255',
            'user_id' => 'required',
            'add_option' => 'required',
        ]);

        $question = Question::create($data);

        // add Translations question_text_[Language name]
        foreach(Language::all() as $language) {
            Translation::createOrUpdate([
                'question_id' => $question->id,
                'language_id' => $language->id,
                'translated_text' => $request->input('question_text_' . $language->id),
            ]);
        }


        if($request->add_option == 1) {
            return redirect()->route('dashboard.question.create', ['quiz_id' => $quiz->id]);
        }
        return redirect()->route('dashboard.quizzes');
    }




}
