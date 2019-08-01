<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostEarning extends Model
{
    protected $fillable = ['user_id', 'duration', 'minutes', 'country_id'];

    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
