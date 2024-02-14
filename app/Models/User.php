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

    /**
     * Send a message to the user's device using FCM and cURL.
     *
     * @param string $title
     * @param string $body
     * @param string|null $imageUrl
     * @param string|null $actionUrl
     * @return void
     */
    public function sendMessage($title, $body, $imageUrl = null, $actionUrl = null)
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = 'a9b76aa8d4085dcd12b2f5fb4d0e89d82aed2fc1'; // Replace with your server key from Firebase console

        $headers = [
            'Authorization: key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $notification = [
            'title' => $title,
            'body' => $body,
        ];

        if (!is_null($imageUrl)) {
            $notification['image'] = $imageUrl;
        }

        $postData = [
            'to' => $this->fcm_token,
            'notification' => $notification,
            'data' => [
                'click_action' => 'FLUTTER_NOTIFICATION_CLICK', // Customize as needed
                'url' => $actionUrl,
            ],
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fcmUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        curl_close($ch);

        // Optionally, you can log the result for debugging purposes
        \Log::info("FCM response: " . $result);
    }

}
