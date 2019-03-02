<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'store_id', 'title', 'description', 'coupon', 'type', 'link', 'aff_link', 'expiry_date'
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'expiry_date' => 'datetime'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
