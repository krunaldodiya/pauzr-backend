<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Plan;

class TestController extends Controller
{
    public function test(Request $request)
    {
        $plans = Plan::with('features', 'subscriptions')->get();

        return compact('plans');
    }
}
