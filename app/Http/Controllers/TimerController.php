<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Timer;

use Carbon\Carbon;
use App\User;
use App\GroupSubscription;

class TimerController extends Controller
{
    public function setTimer(Request $request)
    {
        $user = auth('api')->user();
        $duration = strval($request->duration);
        $points = ["20" => "1", "40" => "3", "60" => "5"];

        $timer = Timer::create([
            'duration' => $duration,
            'user_id' => $user->id,
            'location_id' => $user->location_id
        ]);

        $transaction = $user->createTransaction($points[$duration], 'deposit', ['description' => "Earned points of TIMER_ID #${timer}"]);
        $user->deposit($transaction->transaction_id);

        return ['success' => true];
    }

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

        $filters = ['timer_history' => function ($query) use ($period, $user) {
            return $query
                ->where('created_at', '>=', $period)
                ->where('location_id', $user->location->id);
        }];

        $users = $this->getUsers($request->groupId, $filters, $user);

        $rankings = $users
            ->map(function ($user) {
                return [
                    'user' => $user,
                    'duration' => $user->timer_history->sum('duration')
                ];
            })
            ->toArray();

        return compact('minutes_saved', 'points_earned', 'rankings');
    }

    public function getUsers($groupId, $filters, $user)
    {
        return  User::with($filters)
            ->where(function ($query) use ($groupId, $user) {
                if ($groupId) {
                    $subscribers = GroupSubscription::where(['group_id' => $groupId])
                        ->pluck('subscriber_id')
                        ->toArray();

                    return $query->whereIn('id', $subscribers);
                } else {
                    return $query->where('location_id', $user->location->id);
                }
            })
            ->orderBy('name', 'asc')
            ->get();
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

        $sum = 0;
        $avg = 0;
        $history = [];

        if ($points->count()) {
            $days = $points->last()->created_at->diffInDays($points->first()->created_at) + 1;

            $sum = $points->sum('amount');
            $avg = round($sum / $days);

            $history = $points->where('created_at', '>=', Carbon::now()->startOfMonth())->toArray();
        }

        return compact('history', 'sum', 'avg');
    }

    public function getMinutesHistory(Request $request)
    {
        $user = auth('api')->user();

        $minutes = Timer::where(['user_id' => $user->id])->get();

        $sum = 0;
        $avg = 0;
        $history = [];

        if ($minutes->count()) {
            $days = $minutes->last()->created_at->diffInDays($minutes->first()->created_at) + 1;

            $sum = $minutes->sum('duration');
            $avg = round($sum / $days);

            $history = $minutes->where('created_at', '>=', Carbon::now()->startOfMonth())->toArray();
        }

        return compact('history', 'sum', 'avg');
    }
}
