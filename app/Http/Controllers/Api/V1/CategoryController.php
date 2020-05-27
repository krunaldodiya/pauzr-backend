<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Category;

class CategoryController extends Controller
{
    public function getCategories(Request $request)
    {
        $categories = Category::get();

        return compact('categories');
    }

    public function getCategoryInfo(Request $request)
    {
        $categories = Category::get();

        return compact('categories');
    }

    public function getStoresByCategory(Request $request)
    {
        $categories = Category::get();

        return compact('categories');
    }
}
