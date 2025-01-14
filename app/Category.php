<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Laravel\Nova\Actions\Actionable;

class Category extends Model
{
    use Actionable;

    protected $fillable = ['parent_id', 'name'];

    protected $dates = ['created_at', 'updated_at'];

    public function stores()
    {
        return $this->hasMany(Store::class);
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, Store::class);
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'category_coupon');
    }

    public function parent_category()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }

    public function child_categories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
