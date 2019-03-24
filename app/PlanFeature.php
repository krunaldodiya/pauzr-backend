<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanFeature extends Model
{
    protected $fillable = ['plan_id', 'name', 'value', 'description', 'sort_order', 'active'];

    protected $dates = ['created_at', 'updated_at'];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
