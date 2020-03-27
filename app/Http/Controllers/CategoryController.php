<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categories(Request $request)
    {
        $categories = Category::with('products.images', 'products.store')->get();

        return compact('categories');
    }
}
