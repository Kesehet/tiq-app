<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'key',
        'value',
    ];

    /**
     * Get the quiz that owns the preference.
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
