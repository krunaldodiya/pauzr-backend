<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['parent_id', 'name'];

    protected $dates = ['created_at', 'updated_at'];

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class);
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