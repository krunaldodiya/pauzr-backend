<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdKeyword extends Model
{
    protected $fillable = ['keywords', 'cpc'];

    protected $dates = ['created_at', 'updated_at'];
}
