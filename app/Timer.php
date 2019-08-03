<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\SetTimer;

class Timer extends Model
{
    protected $fillable = ['user_id', 'duration', 'city_id', 'country_id'];

    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
