<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupSubscriber extends Model
{
    protected $fillable = [
        'is_admin', 'group_id', 'subscriber_id'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
