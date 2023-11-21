<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Translation extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the question that owns the translation.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}


