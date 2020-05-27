<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Product;

class ProductController extends Controller
{
    public function getProductInfo(Request $request)
    {
        $categories = Product::get();

        return compact('categories');
    }
}
