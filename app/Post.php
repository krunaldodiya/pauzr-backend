<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'type', 'url', 'description', 'default'];

    protected $dates = ['created_at', 'updated_at'];

    protected $appends = ['when'];

    public function getWhenAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function earnings()
    {
        return $this->belongsTo(PostEarning::class);
    }
}
