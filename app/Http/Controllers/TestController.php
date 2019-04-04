<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;

class TestController extends Controller
{
    public function test(Request $request)
    {
        return [
            [
                "key" => "color",
                "type" => "MaterialColor",
                "value" => "0xff000000",
                "description" => null
            ]
        ];
    }
}
