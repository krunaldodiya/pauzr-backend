<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GroupSubscriber;
use Carbon\Carbon;
use App\Group;
use App\Level;

class TestController extends Controller
{
    public function check(Request $request)
    {
        return Level::where('points', "<=", 35)
            ->get()
            ->last();
    }
}
