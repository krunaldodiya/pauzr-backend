<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanFeature extends Model
{
    protected $table = "plan_features";

    public function plan()
    {
        $this->belongsTo(Plan::class);
    }
}
