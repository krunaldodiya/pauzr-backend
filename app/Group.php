<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'owner_id', 'name', 'photo', 'status', 'anyone_can_post', 'anyone_can_join'
    ];

    protected $dates = ['created_at', 'updated_at'];
}
