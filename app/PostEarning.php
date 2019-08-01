<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostEarning extends Model
{
    protected $fillable = ['user_id', 'post_id', 'points', 'redeemed'];

    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
