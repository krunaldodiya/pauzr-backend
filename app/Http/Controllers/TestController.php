<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class TestController extends Controller
{
    public function test(Request $request)
    {
        $categories = Category::with('stores')->get();

        return compact('categories');
    }
}
