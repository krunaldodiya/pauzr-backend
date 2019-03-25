<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Laravel\Nova\Actions\Actionable;

class Store extends Model
{
    use Actionable;

    protected $fillable = [
        'user_id', 'type', 'name', 'description', 'website', 'logo', 'city', 'active', 'top_brand'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
