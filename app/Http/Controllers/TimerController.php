<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Timer;

use Carbon\Carbon;
use App\User;
use App\GroupSubscription;
use App\Repositories\UserRepository;

class TimerController extends Controller
{
    public $userRepo;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function setTimer(Request $request)
    {
        $user = auth('api')->user();
        $duration = strval($request->duration);
        $points = ["1" => "1", "2" => "3", "3" => "5", "20" => "1", "40" => "3", "60" => "5"];

        $timer = Timer::create([
            'duration' => $duration,
            'user_id' => $user->id,
            'city_id' => $user->city_id,
        ]);

        $timer_id = $timer['id'];
        $description = "Earned points of TIMER_ID #$timer_id";

        $transaction = $user->createTransaction($points[$duration], 'deposit', ['description' => $description]);
        $user->deposit($transaction->transaction_id);

        $user->upgradeLevel();

        return ['user' => $this->userRepo->getUserById($user->id)];
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

        $groupId = $request->groupId;

        $filters = ['city.state.country', 'state', 'country', 'level', 'timer_history' => function ($query) use ($period, $user, $groupId) {
            return $query
                ->where('created_at', '>=', $period)
                ->where(function ($query) use ($groupId, $user) {
                    if ($groupId) {
                        return $query;
                    } else {
                        return $query->where('city_id', $user->city_id);
                    }
                });
        }];

        $users = $this->getUsers($groupId, $filters, $user);

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
            ->where('status', true)
            ->where(function ($query) use ($groupId, $user) {
                if ($groupId) {
                    $subscribers = GroupSubscription::where(['group_id' => $groupId])
                        ->pluck('subscriber_id')
                        ->toArray();

                    return $query->whereIn('id', $subscribers);
                } else {
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
            ->whereIn('transaction_type', ['deposit'])
            ->where('status', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $sum = 0;
        $avg = 0;
        $history = [];

        if ($points->count()) {
            $days = $points->last()->created_at->diffInDays($points->first()->created_at) + 1;
            $sum = $points->sum('amount');
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
