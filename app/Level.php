<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = ['level', 'points'];

    protected $dates = ['created_at', 'updated_at'];
}
