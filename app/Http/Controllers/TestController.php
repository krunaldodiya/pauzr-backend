<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NewMessage;

class TestController extends Controller
{
    public function check(Request $request)
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

    public function sendMessage(Request $request)
    {
        event(new NewMessage("hello"));
    }
}
