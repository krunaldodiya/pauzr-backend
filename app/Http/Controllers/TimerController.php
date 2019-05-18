<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Timer;

use Carbon\Carbon;
use App\User;

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

        $filters = ['timer_history' => function ($query) use ($period) {
            return $query->where('created_at', '>=', $period);
        }];

        $rankings = User::with($filters)
            ->where('location_id', $user->location->id)
            ->orderBy('name', 'asc')
            ->get()
            ->map(function ($user) {
                return [
                    'user' => $user,
                    'duration' => $user->timer_history->sum('duration')
                ];
            })
            ->sortByDesc('duration')
            ->map(function ($data, $index) {
                return [
                    'user' => $data['user'],
                    'duration' => $data['duration'],
                    'rank' => $index + 1
                ];
            })
            ->toArray();

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
