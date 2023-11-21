<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;




class Question extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the quiz that owns the question.
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the translations for the question.
     */
    public function translations()
    {
        return $this->hasMany(Translation::class);
    }

    /**
     * Get the options for the question.
     */
    public function options()
    {
        return $this->hasMany(Option::class);
    }
}