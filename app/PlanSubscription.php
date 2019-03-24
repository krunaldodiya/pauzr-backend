<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanSubscription extends Model
{
    protected $table = "plan_subscriptions";

    protected $fillable = [
        'user_id', 'plan_id', 'name', 'description', 'trial_ends_at', 'subscription_starts_at', 'subscription_ends_at',
        'payment_type', 'payment_status', 'subscription_status'
    ];

    protected $dates = ['created_at', 'updated_at'];

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
