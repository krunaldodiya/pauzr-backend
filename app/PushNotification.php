<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    protected $fillable = [
        'subject', 'title', 'description', 'image'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function subscribers()
    {
        return $this->hasMany(PushNotificationSubscriber::class);
    }
}
