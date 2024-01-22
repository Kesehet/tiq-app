<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    

    protected $fillable = [
        'title',
        'description',
        'featured_image',
    ];
    

    protected $guarded = [];

    /**
     * Get the questions associated with the quiz.
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Retrieve a quiz with all its questions and translations.
     *
     * @param int $quizId
     * @return Quiz
     */
    public static function readQuizWithQuestionsAndTranslations($quizId)
    {
        return self::with(['questions.translations', 'questions.options.translationOptions'])->find($quizId);
    }

    
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'quiz_tag');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'quiz_id');
    }

    


}



