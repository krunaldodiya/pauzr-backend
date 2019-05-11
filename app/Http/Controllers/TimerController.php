<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Timer;

class TimerController extends Controller
{
    public function getTimerHistory(Request $request)
    {
        $user_id = auth('api')->user()->id;

        $timer = Timer::where(['user_id' => $user_id])->get();

        $sum = $timer->sum('duration');
        $avg = $timer->avg('duration');

        $history = $timer
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->toArray();

        return compact('history', 'sum', 'avg');
    }
}
