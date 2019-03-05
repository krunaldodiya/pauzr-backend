<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Laravel\Nova\Actions\Actionable;

class Store extends Model
{
    use Actionable;

    protected $fillable = [
        'merchant_id', 'type', 'name', 'description', 'website', 'logo', 'city', 'active'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
}
