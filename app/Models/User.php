<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use UserPreferences;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;


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
        'fcm_token',
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
    public function sendMessage($title, $body, $imageUrl = null, $actionUrl = null) {

        $serviceAccountPath = storage_path(env('FIREBASE_SERVICE_ACCOUNT_PATH'));
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccountPath) // Path to your Firebase service account JSON file
            ->createMessaging();
    
        $notification = Notification::fromArray([
            'title' => $title,
            'body' => $body,
            'image' => $imageUrl, // This is optional; it can be null
        ]);
    
        $message = CloudMessage::withTarget('token', $this->fcm_token)
            ->withNotification($notification)
            ->withData(['url' => $actionUrl]) // Custom data payload
            ->withHighPriority(); // Set the message priority to high
    
        try {
            $firebase->send($message);
            \Log::info("FCM urgent message sent successfully to: " . $this->name);
            return true;
        } catch (\Kreait\Firebase\Exception\MessagingException $e) {
            \Log::error("FCM urgent message failed to send: " . $e->getMessage());
            return false;
        } catch (\Kreait\Firebase\Exception\FirebaseException $e) {
            \Log::error("Firebase error: " . $e->getMessage());
            return false;
        }
    }
    


}
