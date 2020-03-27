<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Nova\Actions\Actionable;

class ProductImage extends Model
{
    use Actionable;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
