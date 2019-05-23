<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;

class TestController extends Controller
{
    public function check(Request $request)
    {
        $group = Group::find($request->groupId);
        $group->subscribers()->attach($request->participants);

        return ['success' => true];
    }
}
