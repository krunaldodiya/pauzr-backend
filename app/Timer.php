<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timer extends Model
{
    protected $fillable = [
        'user_id', 'duration', 'completed', 'created_at', 'updated_at'
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $appends = ['time'];

    public function getTimeAttribute()
    {
        return $this->created_at->diffInSeconds($this->updated_at);
    }
}
