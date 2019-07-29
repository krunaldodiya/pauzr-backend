<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Refer extends Model
{
    protected $fillable = [
        'utm', 'ip_address', 'languages', 'device', 'platform', 'platform_version', 'browser', 'browser_version', 'robot'
    ];

    protected $dates = ['created_at', 'updated_at'];
}
