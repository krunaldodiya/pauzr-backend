<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GroupSubscriber;
use Carbon\Carbon;

class TestController extends Controller
{
    public function check(Request $request)
    {
        $subscribers = collect($request->participants)
            ->map(function ($subscriber_id) use ($request) {
                return [
                    'group_id' => $request->groupId,
                    'subscriber_id' => $subscriber_id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            })
            ->toArray();

        $group = GroupSubscriber::insert($subscribers);

        return ['group' => $group];
    }
}
