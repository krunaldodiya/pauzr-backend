<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\UserRepository;
use Carbon\Carbon;

use App\Timer;
use App\User;
use App\GroupSubscription;
use App\Winner;
use App\Repositories\TimerRepository;

class TimerController extends Controller
{
    public $userRepository;
    public $timerRepository;

    public function __construct(UserRepository $userRepository, TimerRepository $timerRepository)
    {
        $this->userRepository = $userRepository;
        $this->timerRepository = $timerRepository;
    }

    public function setTimer(Request $request)
    {
        $user = $request->x_user_id ? User::find($request->x_user_id) : auth('api')->user();

        $duration = strval($request->duration);
        $duration_seconds = $duration * 60;

        $last_timer = Timer::where(['user_id' => $user->id])->orderBy('created_at', 'desc')->first();
        $time_passed_seconds = $last_timer ? $last_timer->created_at->diffInSeconds(Carbon::now()) : 3600;

        if ($time_passed_seconds >= $duration_seconds) {
            $user = $this->timerRepository->setTimer($user, $duration);
            return ['user' => $this->userRepository->getUserById($user->id)];
        }

        return response(['error' => "Invalid Request"], 403);
    }

    public function getWinners(Request $request)
    {
        $user = auth('api')->user();

        $period = $request->period ?? 'Week';
        $period_date = $period == 'Week' ? Carbon::now()->startOfWeek() : Carbon::now()->startOfMonth();

        $winners = Winner::with('user.city')
            ->where(['country_id' => $user->country_id])
            ->where('period', $period)
            ->where('created_at', ">=", $period_date)
            ->orderBy('duration', 'desc')
            ->limit(10)
            ->get();

        return response(['winners' => $winners], 200);
    }

    public function getRankings(Request $request)
    {
        $user = auth('api')->user();

        $location = $request->location ? $request->location : "city";

        $period = $this->filterPeriod($request->period);

        $minutes = Timer::where(['user_id' => $user->id])
            ->where('created_at', '>=', $period)
            ->where(function ($query) use ($location, $user) {
                if ($location == "country") {
                    return $query->where('country_id', $user->country_id);
                }

                return $query->where('city_id', $user->city_id);
            })
            ->get();

        $minutes_saved = $minutes->sum('duration');

        $points = $user->wallet->transactions()
            ->whereIn('transaction_type', ['deposit'])
            ->where('status', true)
            ->where('created_at', '>=', $period)
            ->get();

        $points_earned = $points->sum('amount');

        $groupId = $request->groupId;

        $user_filters = ['city.state.country', 'state', 'country', 'level', 'timer_history' => function ($query) use ($period, $location, $user, $groupId) {
            return $query
                ->where('created_at', '>=', $period)
                ->where(function ($query) use ($location, $user, $groupId) {
                    if ($groupId) {
                        return $query;
                    } else {
                        if ($location == "country") {
                            return $query->where('country_id', $user->country_id);
                        }

                        return $query->where('city_id', $user->city_id);
                    }
                });
        }];

        $users = $this->getUsers($user_filters, $groupId, $user, $location);

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

    public function getUsers($user_filters, $groupId, $user, $location)
    {
        return  User::with($user_filters)
            ->where('status', true)
            ->where(function ($query) use ($groupId, $user, $location) {
                if ($groupId) {
                    $subscribers = GroupSubscription::where(['group_id' => $groupId])
                        ->pluck('subscriber_id')
                        ->toArray();

                    return $query->whereIn('id', $subscribers);
                } else {
                    if ($location == "country") {
                        return $query->where('country_id', $user->country_id);
                    }

                    return $query->where('city_id', $user->city_id);
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
            ->where('status', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $sum = 0;
        $avg = 0;
        $history = [];

        if ($points->count()) {
            $days = $points->last()->created_at->diffInDays($points->first()->created_at) + 1;

            $deposit = $points->whereIn('transaction_type', ['deposit'])->sum('amount');
            $withdraw = $points->whereIn('transaction_type', ['withdraw'])->sum('amount');

            $sum = $deposit - $withdraw;
            $avg = round($sum / $days);
            $history = $points;
        }

        return response(compact('history', 'sum', 'avg'), 200);
    }

    public function getMinutesHistory(Request $request)
    {
        $user = auth('api')->user();
        $minutes = Timer::where(['user_id' => $user->id])
            ->orderBy('created_at', 'desc')
            ->get();

        $sum = 0;
        $avg = 0;
        $history = [];

        if ($minutes->count()) {
            $days = $minutes->last()->created_at->diffInDays($minutes->first()->created_at) + 1;
            $sum = $minutes->sum('duration');
            $avg = round($sum / $days);
            $history = $minutes;
        }

        return response(compact('history', 'sum', 'avg'), 200);
    }
}
