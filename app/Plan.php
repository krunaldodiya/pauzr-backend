<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    public function subscribers()
    {
        $this->hasMany(PlanSubscription::class);
    }

    public function features()
    {
        $this->hasMany(PlanFeature::class);
    }
}
