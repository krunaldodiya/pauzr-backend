<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name', 'shortname', 'phonecode'
    ];

    protected $dates = ['created_at', 'updated_at'];
}
