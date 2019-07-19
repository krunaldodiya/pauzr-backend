<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Fields\Country;

class City extends Model
{
    protected $fillable = [
        'name', 'state_id'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
