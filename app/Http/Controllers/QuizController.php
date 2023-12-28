<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Option;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class QuizController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function submit(Request $request, $quizId)
    {
        $user = auth()->user(); // Get the authenticated user
        $answersData = $request->input('answers');

        

        foreach ($answersData as $questionId => $optionId) {
            $isCorrect = false;
            $option = Option::find($optionId);

            // Check if the selected option is correct
            if ($option && $option->is_correct) {
                $isCorrect = true;
            }

            // Save the answer
            Answer::updateOrCreate([
                'user_id' => $user->id,
                'quiz_id' => $quizId,
                'question_id' => $questionId,
            ],[
                'option_id' => $optionId,
                'is_correct' => $isCorrect,
                
            ]);
        }

        // Redirect to the results page or return a response
        return response()->json(['success' => 'Quiz submitted successfully.']);
    }



    



}
