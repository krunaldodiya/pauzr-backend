<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Events\UserWasCreated;

use Carbon\Carbon;
use Tymon\JWTAuth\Contracts\JWTSubject;

use Laravel\Nova\Actions\Actionable;
use KD\Wallet\Traits\HasWallet;
use Laravel\Scout\Searchable;

class User extends Authenticatable implements JWTSubject
{
    use HasWallet;

    use Actionable, Notifiable;

    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fcm_token', 'name', 'email', 'email_verified_at', 'mobile_cc', 'mobile', 'password', 'dob',
        'gender', 'avatar', 'country_id', 'state_id', 'city_id', 'level_id', 'status', 'is_merchant',
        'is_admin', 'remember_token', 'bio', 'intro_completed', 'version'
    ];

    protected $dates = ['created_at', 'updated_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['age'];

    protected $dispatchesEvents = [
        'created' => UserWasCreated::class
    ];

    public function getAgeAttribute()
    {
        return $this->dob ? Carbon::parse($this->dob)->age : 0;
    }

    public function getAvatarAttribute($avatar)
    {
        $defaultAvatar = $this->images()->where('type', 'avatar')->where('default', true)->first();

        return $defaultAvatar == null ? "default.jpeg" : $defaultAvatar->url;
    }

    public function contacts()
    {
        return $this->hasMany(UserContact::class);
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function impressions()
    {
        return $this->hasMany(AdImpression::class);
    }

    public function followers()
    {
        return $this->hasMany(Follow::class, 'following_id');
    }

    public function followings()
    {
        return $this->hasMany(Follow::class, 'follower_id');
    }

    public function images()
    {
        return $this->hasMany(Post::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function timer_history()
    {
        return $this->hasMany(Timer::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Post::class, 'favorites');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function subscription()
    {
        return $this->hasOne(PlanSubscription::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function isAdminOrMerchant()
    {
        return $this->isAdmin() || $this->isMerchant();
    }

    public function isAdmin()
    {
        return $this->is_admin || in_array($this->email, [
            'kunal.dodiya1@gmail.com',
            'aryanadya@gmail.com'
        ]);
    }

    public function isMerchant()
    {
        return $this->is_merchant;
    }

    public function searchableAs()
    {
        return 'name';
    }

    public function upgradeLevel()
    {
        $credits = $this->wallet->transactions()
            ->whereIn('transaction_type', ['deposit'])
            ->where('status', true)
            ->sum('amount');

        $level = Level::where('points', "<=", $credits)
            ->get()
            ->last();

        $this->update(['level_id' => $level->id]);
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
