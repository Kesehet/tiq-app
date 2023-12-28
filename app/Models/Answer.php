<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends Model
{
    use HasFactory;

    // Assuming timestamps are needed
    public $timestamps = true;

    // Fillable fields for mass assignment
    protected $fillable = ['user_id', 'quiz_id', 'question_id', 'option_id', 'is_correct'];

    /**
     * The user who provided this answer.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The question this answer is related to.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function score()
    {
        // Example: Assign 1 point for each correct answer
        if ($this->option && $this->option->is_correct) {
            return $this->option->score; // Use the score from the Option model
        }
        return 0;
    }

    /**
     * The option chosen for this answer, if it's a multiple-choice question.
     */
    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    // Additional methods or attributes can be added as needed
}
