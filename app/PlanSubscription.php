<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanSubscription extends Model
{
    protected $table = "plan_subscriptions";

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'trial_ends_at' => 'datetime',
        'subscription_starts_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
    ];

    public function user()
    {
        $this->belongsTo(User::class);
    }

    public function plan()
    {
        $this->belongsTo(Plan::class);
    }
}
