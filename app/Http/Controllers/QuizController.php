<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuizController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function submit(Request $request, $id) {
        


        $answers = $request->input('answers');
            
        return request()->json(['success' => true]);
    }

}
