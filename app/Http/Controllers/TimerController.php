<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Timer;

use Carbon\Carbon;

class TimerController extends Controller
{
    public function getRankings(Request $request)
    {
        $user = auth('api')->user();

        $period = $this->filterPeriod($request->period);

        $minutes = Timer::where(['user_id' => $user->id])
            ->where('created_at', '>=', $period)
            ->get();

        $minutes_saved = $minutes->sum('duration');

        $points = $user->wallet->transactions()
            ->whereIn('transaction_type', ['deposit'])
            ->where('status', true)
            ->where('created_at', '>=', $period)
            ->get();

        $points_earned = $points->sum('amount');

        $history = Timer::with('user')
            ->where('created_at', '>=', $period)
            ->where('location_id', $user->location->id)
            ->get();

        $rankings = [];

        foreach ($history as $timer) {
            $duration = isset($rankings[$timer['user_id']]) ? $rankings[$timer['user_id']]['duration'] : 0;

            $rankings[$timer['user_id']] = [
                'duration' => $duration + $timer['duration'],
                'user' => $timer['user']
            ];
        }

        $rankings = collect($rankings)
            ->sortByDesc('duration')
            ->map(function ($ranking, $index) {
                return [
                    'rank' => $index,
                    'duration' => $ranking['duration'],
                    'user' => $ranking['user']
                ];
            });

        return compact('minutes_saved', 'points_earned', 'rankings');
    }

    public function filterPeriod($period)
    {
        if ($period == 'Today') {
            return Carbon::now()->startOfDay();
        }

        if ($period == 'This Week') {
            return Carbon::now()->startOfWeek();
        }

        if ($period == 'This Month') {
            return Carbon::now()->startOfMonth();
        }
    }

    public function getPointsHistory(Request $request)
    {
        $user = auth('api')->user();

        $points = $user->wallet->transactions()
            ->whereIn('transaction_type', ['deposit'])
            ->where('status', true)
            ->get();

        $days = $points->last()->created_at->diffInDays($points->first()->created_at) + 1;

        $sum = $points->sum('amount');

        $avg = $sum / $days;

        $history = $points
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->toArray();

        return compact('history', 'sum', 'avg');
    }

    public function getMinutesHistory(Request $request)
    {
        $user = auth('api')->user();

        $minutes = Timer::where(['user_id' => $user->id])->get();

        $days = $minutes->last()->created_at->diffInDays($minutes->first()->created_at) + 1;

        $sum = $minutes->sum('duration');

        $avg = $sum / $days;

        $history = $minutes
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->toArray();

        return compact('history', 'sum', 'avg');
    }
}
