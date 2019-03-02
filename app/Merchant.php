<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Laravel\Nova\Actions\Actionable;

class Merchant extends Model
{
    use Actionable;
    
    protected $fillable = [
        'user_id', 'is_active', 'status'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function setMerchantPasswordAttribute($merchant_password)
    {
        return $this->attributes['merchant_password'] = bcrypt($merchant_password);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }
}
