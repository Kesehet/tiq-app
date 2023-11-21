<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranslationOption extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the option that owns the translation option.
     */
    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
