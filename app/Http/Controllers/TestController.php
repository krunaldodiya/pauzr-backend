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
        $user = auth()->user();
        $group = GroupSubscriber::where(['group_id' => $group->id, 'subscriber_id' => $user->id])->first();

        // if ($group->owner_id == $user->id) {
        //     $group->delete();
        // }

        // if ($group->owner_id != $user->id) {
        //     $subscription = GroupSubscriber::where(['group_id'->$group->id, 'subscriber_id'->$user->id])->first();
        //     $subscription->delete();
        // }

        return response(['group' => $group], 200);
    }
}
