<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GroupSubscriber;
use Carbon\Carbon;
use App\Group;

class TestController extends Controller
{
    public function check(Request $request)
    {
        $group = GroupSubscriber::where(['group_id' => 1, 'subscriber_id' => 1])->first();

        return response(['group' => $group], 200);
    }
}
