<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function check(Request $request)
    {
        $user = User::first();

        dd($user);
    }
}
