<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PushNotificationSubscriber extends Model
{
    protected $fillable = [
        'user_id', 'push_notification_id'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public $timestamps = false;

    public function subscriber()
    {
        return $this->belongsTo(User::class);
    }
}
