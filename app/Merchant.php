<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
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
