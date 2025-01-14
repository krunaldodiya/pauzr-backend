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

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes()
    {
        return $this->hasMany(Favorite::class);
    }

    public function earnings()
    {
        return $this->hasOne(PostEarning::class);
    }
}
