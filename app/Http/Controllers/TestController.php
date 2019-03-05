<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class TestController extends Controller
{
    public function test(Request $request)
    {
        $user = User::find(2);

        $role = $user->hasRole(['Merchant']);

        return compact('role');
    }
}
