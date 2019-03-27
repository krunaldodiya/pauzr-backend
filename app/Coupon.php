<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Laravel\Nova\Actions\Actionable;

class Coupon extends Model
{
    use Actionable;

    protected $fillable = [
        'store_id', 'title', 'description', 'type', 'coupon', 'logo', 'link', 'aff_link', 'start_date', 'expiry_date', 'sort_order'
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'start_date' => 'date:d-m-Y',
        'expiry_date' => 'date:d-m-Y',
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
