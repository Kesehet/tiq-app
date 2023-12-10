<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function submit(Request $request) {
        $answers = $request->input('answers');

        // Validate and process answers...
        // Return a response (success, score, etc.)
    }

}
