<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = ['image', 'name'];

    protected $dates = ['created_at', 'updated_at'];
}
