<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Laravel\Nova\Actions\Actionable;

class Coupon extends Model
{
    use Actionable;

    protected $fillable = [
        'store_id', 'title', 'description', 'type', 'coupon', 'logo', 'link', 'aff_link', 'start_date', 'expiry_date'
    ];

    protected $dates = ['start_date', 'expiry_date', 'created_at', 'updated_at'];

    protected $casts = [
        'start_date' => 'datetime',
        'expiry_date' => 'datetime',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_coupon');
    }
}
