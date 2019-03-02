<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Events\UserWasCreated;

use Carbon\Carbon;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'email_verified_at', 'password', 'avatar', 'mobile', 'dob', 'gender', 'status', 'remember_token'
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
        'dob' => 'date',
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

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function merchant()
    {
        return $this->hasOne(Merchant::class);
    }

    public function isAdminOrMerchant()
    {
        return $this->isAdmin() || $this->isMerchant();
    }

    public function isAdmin()
    {
        return $this->roles->contains('name', 'admin');
    }

    public function isMerchant()
    {
        return $this->merchant->count();
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
