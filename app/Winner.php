<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
    protected $fillable = ['user_id', 'minutes', 'country_id', 'duration'];

    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
