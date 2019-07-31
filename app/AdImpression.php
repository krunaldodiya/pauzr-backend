<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdImpression extends Model
{
    protected $fillable = ['user_id', 'type'];

    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
