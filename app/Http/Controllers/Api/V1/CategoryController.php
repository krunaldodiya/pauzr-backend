<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Category;
use App\Product;
use App\Store;

class CategoryController extends Controller
{
    public function getCategories(Request $request)
    {
        $categories = Category::get();

        return compact('categories');
    }

    public function getCategoryInfo(Request $request)
    {
        $category = Category::with('products')
            ->where('id', $request->category_id)
            ->first();

        return compact('category');
    }

    public function getStoresByCategory(Request $request)
    {
        $stores = Store::with('category')
            ->where('category_id', $request->category_id)
            ->paginate();

        return compact('stores');
    }

    public function getProductsByCategory(Request $request)
    {
        $category = Category::with('store')->find($request->category_id);

        $products = Product::with('store')
            ->where('store_id', $category->store_id)
            ->paginate();

        return compact('products');
    }
}
