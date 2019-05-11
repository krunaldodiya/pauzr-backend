<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
    protected $fillable = ['user_id', 'duration'];

    protected $dates = ['created_at', 'updated_at'];
}
