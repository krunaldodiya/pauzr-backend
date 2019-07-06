<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = ['sender_id', 'mobile_cc'];

    protected $dates = ['created_at', 'updated_at'];
}
