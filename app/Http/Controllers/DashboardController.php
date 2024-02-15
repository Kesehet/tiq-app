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
use App\Models\Tag;
use App\Models\TranslationOption;




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
          $languagecount = Language::all()->count();

        $recentQuiz = Quiz::latest()->take(5)->get();

        $recentQuizzes = Quiz::withCount(['answers as attempts' => function ($query) {
            $query->select(DB::raw('count(distinct user_id)'));
        }])
        ->orderBy('attempts', 'desc') // Sort by number of attempts
        ->get();

        $recentQuizStats = ['labels' => [], 'data' => []];

        foreach ($recentQuizzes as $quiz) {
            if ($quiz->attempts > 0) {
                $recentQuizStats['labels'][] = $quiz->title;
                $recentQuizStats['data'][] = $quiz->attempts;
            }
        }




         return view('dashboard.index',
         [
         'showPage'  => 'home',
         'quizcount' => $quizcount,
         'questioncount'  => $questioncount,
         'languagecount'     => $languagecount,
         'usercount'   => $usercount,
         'recentQuiz'=> $recentQuiz,
         "recentQuizStats"=>$recentQuizStats,



         ]);


         }


    }

    public function languages(Request $request){
        $user = Auth::user();
        if(!$user->isTeamMember()) {
            return redirect()->route('home');
        }

        $languages = Language::all();
        return view('dashboard.index',[
            'showPage' => 'languageAll',
            'languages' => $languages
        ]);
    }

    public function languageStore(Request $request){
        $user = Auth::user();
        if(!$user->isTeamMember()) {
            return redirect()->route('home');
        }

        $data = $request->validate([
            'name' => 'required|max:255',
            'code' => 'required|max:255',
            'font' => 'required|max:255',
        ]);


        $language = Language::updateOrCreate([
            'code' => $data['code']
        ],[
            'name' => $data['name'],
            'font' => $data['font'],
        ]);

        return redirect()->route('dashboard.languages');
    }

    public function languageDelete(Request $request, $id){
        $user = Auth::user();
        if(!$user->isTeamMember()) {
            return redirect()->route('home');
        }

        Translation::where('language_id', $id)->delete();
        TranslationOption::where('language_id', $id)->delete();
        // set users with this language to default
        User::where('language_id', $id)->update(['language_id' => Language::where("id", "!=", $id)->first()->id]);

        $language = Language::find($id);
        $language->delete();
        return redirect()->route('dashboard.languages');
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

        $quizTitle = "";
        $quizDescription = "";
        $quiz_id = "";

        // check if there is a quiz id in the request
        if ($request->has('quiz_id')) {
            // Quiz id exists in the request
            // We will edit the quiz if it exists
            $quiz = Quiz::find($request->input('quiz_id'));
            if ($quiz) {
                // Quiz exists
                $quizTitle = $quiz->title;
                $quizDescription = $quiz->description;
                $quiz_id = $quiz->id;
            } else {
                // Quiz does not exist
            }
        }


        return view('dashboard.index', [
            'showPage' => 'quizCreate',
            'quiz_id' => $quiz_id,
            'quizTitle' => $quizTitle,
            'quizDescription' => $quizDescription
        ]);
    }



    public function quizStore(Request $request){
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

        // update or create the quiz
        $quiz = Quiz::updateOrCreate([
            'id' => $request->input('quiz_id')
        ],[
            'title' => $data['title'],
            'description' => $data['description'],
        ]
        );

        if($request->add_question == 1) {
            return redirect()->route('dashboard.question.create', ['quiz_id' => $quiz->id]);
        }
        return redirect()->route('dashboard.quizzes');
    }

    public function quizDelete(Request $request, $id){
        $user = Auth::user();
        if(!$user->isTeamMember()) {
            return redirect()->route('home');
        }

        $quiz = Quiz::find($id);

        $questions = Question::where('quiz_id', $quiz->id);
        foreach($questions as $question) {
            // Delete all options in the question
            $options = Option::where('question_id', $question->id);
            foreach($options as $option) {
                TranslationOption::where('option_id', $option->id)->delete();
                $option->delete();
            }

            // Delete all answers in the question
            $answers = Answer::where('question_id', $question->id);
            foreach($answers as $answer) {
                $answer->delete();
            }
            // Delete all translations in the question
            $translations = Translation::where('question_id', $question->id);
            foreach($translations as $translation) {
                $translation->delete();
            }
            // Delete the question
            $question->delete();
        }
        // Delete the quiz
        $quiz->delete();
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
            'questions' => $questions,
            'languages' => Language::all()
        ]);
    }


    public function questionCreate(Request $request){
        $user = Auth::user();
        if(!$user->isTeamMember()) {
            return redirect()->route('home');
        }

        $question = Question::find($request->question_id ?? 0);


        return view('dashboard.index', [
            'showPage' => 'questionCreate',
            'question_selected' => $question,
            'translations'=> Translation::all(),
            'languages' => Language::all(),
            'quizzes' => Quiz::all(),
            'quiz_selected' => Quiz::find($question->quiz_id ?? 0)
        ]);
    }

    public function questionDelete(Request $request, $id){
        $user = Auth::user();
        if(!$user->isTeamMember()) {
            return redirect()->route('home');
        }

        $question = Question::find($id);
        $question->delete();
        return redirect()->route('dashboard.questions');
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
        ]);

        $question = Question::updateOrCreate(['id' => $request->question_id],$data);

        // add Translations question_text_[Language name]
        foreach(Language::all() as $language) {
            Translation::updateOrCreate([

                'question_id' => $question->id,
                'language_id' => $language->id,
            ],[
                'translated_text' => $request->input('question_text_' . $language->id),
            ]);
        }


        if($request->add_option == 1) {
            return redirect()->route('dashboard.question.create', ['quiz_id' => $quiz->id]);
        }
        return redirect()->route('dashboard.questions');
    }




    public function combined(){
        $languages = Language::all();
        return view('dashboard.index',[
            'showPage' => 'questionCombo',
            'languages' => $languages
        ]);
    }

    public function combinedStore(Request $request){

        $user = Auth::user();
        if(!$user->isTeamMember()) {
            return redirect()->route('home');
        }

        //dd([$request->all(),$request->questions]);

        $questions = $request->questions;

        $quiz = Quiz::create([
            'title' => $request->name,
            'description' => $request->description,
            'featured_image' => $request->featured_image,
        ]);

        QuizPreference::updateOrCreate([
            'quiz_id' => $quiz->id,
            'key' => 'showAnswers',
        ],[
            'value' => $request->show_answers,
        ]);
        QuizPreference::updateOrCreate([
            'quiz_id' => $quiz->id,
            'key' => 'canChangeAnswers',
        ],[
            'value' => $request->can_change_answer,
        ]);
        foreach($questions as $question) {
            $questionNow = Question::updateOrCreate([
                'question_text' => $question['question_text'] ?? '<div></div>',
                'quiz_id' => $quiz->id,
            ],[]);

            $languages = $question['languages'];
            foreach($languages as $language) {
                Translation::updateOrCreate([
                    'language_id' => $language['id'],
                    'question_id' => $questionNow->id,
                ],[

                    'translated_text' => $language['text'] ? $language['text'] : ''
                ]);
            }

            foreach($question['options'] as $option) {
                $optionNow = Option::create([
                    'question_id' => $questionNow->id,
                    'option_text' => $option['text'],
                    'is_correct' => $option['is_correct'],
                    'score' => $option['score'],
                    'type' => "text"
                ]);

                foreach($option['languages'] as $language) {
                    TranslationOption::updateOrCreate([
                        'option_id' => $optionNow->id,
                        'language_id' => $language['id']
                    ],[
                        'translated_text' => $language['text'] ? $language['text'] : ' This Option is not available in your language. '
                    ]);
                }
            }
        }

        return response()->json($request->all());
    }
    public function users(){
        $user = Auth::user();
        if(!$user->isTeamMember()) {
            return redirect()->route('home');
        }
         return view('dashboard.index', [
                     'showPage' => 'users',
                      'Users' => User::all(),
                 ]);

    }


    public function changeRole(Request $request, $userId){
        // Retrieve the user by ID
        $user = User::find($userId);
        // Check if the user exists
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Validate the incoming request
        $validatedData = $request->validate([
            'role' => 'required|string|in:admin,team,user', // Adjust the role options as needed
        ]);
        // Get the requested role
        $requestedRole = $validatedData['role'];
        // Assign the requested role to the user
        $user->role = $requestedRole;
        // Save the user
        $user->save();
        // Return a success response
        return response()->redirect(route('dashboard.users'));
    }



}
