<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class Product extends Model
{
    use Actionable;

    protected $guarded = [];

    protected $dates = ['created_at', 'updated_at'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function coupon()
    {
        return $this->hasOne(Coupon::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
