<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function check(Request $request)
    {
        return "test";
    }
}
