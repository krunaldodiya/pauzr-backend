<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = ['follower_id', 'following_id'];

    protected $dates = ['created_at', 'updated_at'];

    public function follower_user()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }

    public function following_user()
    {
        return $this->belongsTo(User::class, 'following_id');
    }
}
