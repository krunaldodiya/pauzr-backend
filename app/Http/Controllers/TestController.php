<?php

namespace App\Http\Controllers;

class TestController extends Controller
{
    public function check(Request $request)
    {
        dd("test");
    }
}
