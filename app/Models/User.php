<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $guard_name = ['api'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'otp',
        'otp_expires_at',
        'referral_code',
        'referral_by',
        'coin',
        'last_activity_at',
        'stripe_account_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'roles'
    ];

    protected $appends = [
        'role',
        'referral_link',
        'is_online',
        'is_stripe_connected',
        'is_following',
        'is_blocked',
        'balance'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'otp_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getAvatarAttribute($value): string | null
    {
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }
        // Check if the request is an API request
        if (request()->is('api/*') && !empty($value)) {
            // Return the full URL for API requests
            return url($value);
        }

        // Return only the path for web requests
        return $value;
    }

    public function getImageAttribute($value): string | null
    {
        if (filter_var($value, FILTER_VALIDATE_URL)) {
            return $value;
        }
        // Check if the request is an API request
        if (request()->is('api/*') && !empty($value)) {
            // Return the full URL for API requests
            return url($value);
        }

        // Return only the path for web requests
        return $value;
    }

    public function getRoleAttribute()
    {
        return  $this->getRoleNames()->first();
    }

    public function getIsOnlineAttribute()
    {
        return $this->last_activity_at > now()->subMinutes(5);
    }

    public function getIsStripeConnectedAttribute()
    {
        return !empty($this->stripe_account_id);
    }

    public function getIsFollowingAttribute()
    {
        return Auth::guard('api')->check() ? $this->followers()->where('follower_id', Auth::guard('api')->id())->exists() : false;
    }

    public function getIsBlockedAttribute()
    {
        return Auth::guard('api')->check() ? $this->blocks()->where('blocked_id', Auth::guard('api')->id())->exists() : false;
    }

    public function getBalanceAttribute()
    {
        $increment = Transaction::where('user_id', $this->id)->where('type', 'increment')->sum('amount');
        $decrement = Transaction::where('user_id', $this->id)->where('type', 'decrement')->sum('amount');
        return $increment - $decrement;
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function firebaseTokens()
    {
        return $this->hasMany(FirebaseTokens::class);
    }

    public function search()
    {
        return $this->hasOne(Search::class);
    }

    public function favorite()
    {
        return $this->hasMany(Favorite::class);
    }

    public function getReferralLinkAttribute()
    {
        return env('APP_URL') . '/register?ref=' . $this->referral_code;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function reaches()
    {
        return $this->hasMany(Reach::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function senders()
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }

    public function receivers()
    {
        return $this->hasMany(Chat::class, 'receiver_id');
    }

    public function roomsAsUserOne()
    {
        return $this->hasMany(Room::class, 'user_one_id');
    }

    public function roomsAsUserTwo()
    {
        return $this->hasMany(Room::class, 'user_two_id');
    }

    public function allRooms()
    {
        return Room::where('user_one_id', $this->id)
            ->orWhere('user_two_id', $this->id);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function unavailables()
    {
        return $this->hasMany(Unavailable::class);
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function blocks()
    {
        return $this->belongsToMany(User::class, 'blocks', 'user_id', 'blocked_id');
    }
}
