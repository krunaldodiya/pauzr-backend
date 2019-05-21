<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGroup;
use App\Group;
use App\GroupSubscriber;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function create(CreateGroup $request)
    {
        $user = auth('api')->user();

        $group = Group::create([
            'name' => $request->name,
            'owner_id' => $user->id,
            'anyone_can_post' => false,
            'anyone_can_join' => true,
        ]);

        $group->subscribers()->create([
            'subscriber_id' => $user->id,
            'is_admin' => true
        ]);

        return ['group' => $group];
    }

    public function get(Request $request)
    {
        $user = auth('api')->user();

        $groups = GroupSubscriber::with('group.subscribers')->where(['subscriber_id' => $user->id])->get();

        return ['groups' => $groups];
    }
}
