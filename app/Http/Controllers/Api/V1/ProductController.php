<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Product;

class ProductController extends Controller
{
    public function getProductInfo(Request $request)
    {
        $product = Product::with('images', 'store', 'store.category', 'coupon')
            ->where('id', $request->product_id)
            ->first();

        return compact('product');
    }
}
