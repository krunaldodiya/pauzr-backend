<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanFeature extends Model
{
    protected $table = "plan_features";

    protected $fillable = ['plan_id', 'name', 'value', 'description', 'sort_order', 'active'];

    protected $dates = ['created_at', 'updated_at'];

    public function plan()
    {
        $this->belongsTo(Plan::class);
    }
}
