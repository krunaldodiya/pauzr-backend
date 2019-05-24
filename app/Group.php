<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'owner_id', 'name', 'photo', 'status', 'anyone_can_post', 'anyone_can_join'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function getPhotoAttribute($photo)
    {
        return $photo == null ? "default.jpeg" : $photo;
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function subscribers()
    {
        return $this->hasMany(GroupSubscriber::class);
    }
}
