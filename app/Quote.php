<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'author', 'title', 'image', 'order', 'type'
    ];

    protected $dates = ['created_at', 'updated_at'];
}
