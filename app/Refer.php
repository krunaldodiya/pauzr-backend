<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refer extends Model
{
    protected $fillable = [
        'ip_address', 'languages', 'device', 'platform', 'browser', 'robot', 'version'
    ];

    protected $dates = ['created_at', 'updated_at'];
}
