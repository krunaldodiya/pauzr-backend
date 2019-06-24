<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Events\UserWasCreated;

use Carbon\Carbon;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Scout\Searchable;

use Laravel\Nova\Actions\Actionable;
use KD\Wallet\Traits\HasWallet;

class User extends Authenticatable implements JWTSubject
{
    use HasWallet;

    use Actionable, Notifiable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fcm_token', 'name', 'email', 'email_verified_at', 'mobile', 'password', 'dob', 'gender', 'avatar', 'location_id', 'level_id', 'status', 'is_merchant', 'is_admin', 'remember_token'
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
        return $avatar == null ? "default.jpeg" : $avatar;
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function timer_history()
    {
        return $this->hasMany(Timer::class);
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

    public function location()
    {
        return $this->belongsTo(Location::class);
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
