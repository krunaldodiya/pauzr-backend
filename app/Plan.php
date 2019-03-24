<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['name', 'description', 'price', 'trial_days', 'subscription_period', 'sort_order', 'active'];

    protected $dates = ['created_at', 'updated_at'];

    public function subscriptions()
    {
        return $this->hasMany(PlanSubscription::class);
    }

    public function features()
    {
        return $this->hasMany(PlanFeature::class);
    }
}
