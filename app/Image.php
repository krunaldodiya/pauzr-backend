<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['user_id', 'type', 'url', 'default'];

    protected $dates = ['created_at', 'updated_at'];

    public function getCreatedAtAttribute($created_at)
    {
        return $created_at->diffForHumans();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
