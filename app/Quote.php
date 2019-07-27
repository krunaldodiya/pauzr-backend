<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'name', 'country_id'
    ];

    protected $dates = ['created_at', 'updated_at'];
}
