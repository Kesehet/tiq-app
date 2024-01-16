<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use UserPreferences;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isTeamMember()
    {
        
        return $this->role === 'admin' || $this->role === 'team';
    }

    /**
     * Retrieves the language associated with the user.
     *
     * @throws \Exception if there is an error retrieving the language.
     * @return \App\Language|null The language associated with the user, or null if not found.
     */
    public function language()
    {
        $ret = $this->belongsTo(Language::class);
        if ($ret != null) {
            return $this->belongsTo(Language::class);
        }
        $preff = UserPreference::where('user_id', $this->id)->where('key', 'language')->get()->first();
        if ($preff) {
            $this->language = Language::find($preff->value);
            $this->save();
            return  $this->language;
        }
        return null;
    }

    public function preferences()
    {
        return $this->hasMany(UserPreference::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }


}
