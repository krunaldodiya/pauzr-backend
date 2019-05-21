<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGroup;
use App\Group;

class GroupController extends Controller
{
    public function create(CreateGroup $request)
    {
        return ['group' => null];

        // $group = Group::create(['name' => $request->name]);

        // return ['group' => $group];
    }
}
