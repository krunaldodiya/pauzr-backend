<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Events\UserWasCreated;

use Carbon\Carbon;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Scout\Searchable;

use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Traits\HasWallets;

use Spatie\Permission\Traits\HasRoles;

use Laravel\Nova\Actions\Actionable;

class User extends Authenticatable implements JWTSubject, Wallet
{
    use Actionable, HasWallet, HasWallets, HasRoles, Notifiable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'email_verified_at', 'password', 'avatar', 'mobile', 'dob', 'gender', 'status', 'remember_token'
    ];

    protected $dates = ['dob', 'created_at', 'updated_at'];

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

    public function merchant()
    {
        return $this->hasOne(Merchant::class);
    }

    public function stores()
    {
        return $this->hasManyThrough(Store::class, Merchant::class);
    }

    public function isAdminOrMerchant()
    {
        return $this->hasAnyRole(['Administrator', 'Merchant']);
    }

    public function isAdmin()
    {
        return $this->hasRole(['Administrator']) || in_array($this->email, ['kunal.dodiya1@gmail.com']);
    }

    public function isMerchant()
    {
        return $this->hasRole(['Merchant']);
    }

    public function searchableAs()
    {
        return 'name';
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
