<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Laravel\Nova\Actions\Actionable;

class Store extends Model
{
    use Actionable;

    protected $fillable = [
        'user_id', 'type', 'name', 'description', 'website', 'facebook', 'instagram', 'twitter', 'logo', 'city', 'active', 'top_brand', 'sort_order'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
