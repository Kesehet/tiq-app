<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'slug'];

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class, 'quiz_tag');
    }
}

