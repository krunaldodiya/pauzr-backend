<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = ['sender_id', 'mobile'];

    protected $dates = ['created_at', 'updated_at'];
}
