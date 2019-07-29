<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refer extends Model
{
    protected $fillable = [
        'ip_address'
    ];

    protected $dates = ['created_at', 'updated_at'];
}
