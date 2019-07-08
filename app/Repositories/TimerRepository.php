<?php

namespace App\Repositories;

use App\Repositories\Contracts\TimerRepositoryInterface;

use Carbon\Carbon;

use App\Timer;
use App\Winner;
use App\User;

class TimerRepository implements TimerRepositoryInterface
{
    public function setTimer($user, $duration)
    {
        $points = ["1" => "1", "2" => "3", "3" => "5", "20" => "1", "40" => "3", "60" => "5"];

        $timer = Timer::create([
            'user_id' => $user->id,
            'duration' => $duration,
            'city_id' => $user->city_id,
        ]);

        $timer_id = $timer['id'];
        $description = "Earned points of TIMER_ID #$timer_id";

        $transaction = $user->createTransaction($points[$duration], 'deposit', ['description' => $description]);
        $user->deposit($transaction->transaction_id);

        $user->upgradeLevel();

        return $user;
    }

    public function calculateWinners($user, $period)
    {
        $period_date = $period == 'Week' ? Carbon::now()->startOfWeek() : Carbon::now()->startOfMonth();

        Winner::where('country_id', $user->country_id)
            ->where('period', $period)
            ->where('created_at', '>=', $period_date)
            ->delete();

        $timers = $this->getTimers($user, $period_date);

        $data = [];

        foreach ($timers as $user_id => $timer) {
            $data[$user_id] = [
                'country_id' => $user->country_id,
                'user_id' => $user_id,
                'duration' => $timer->sum('duration'),
                'period' => $period,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        $sorted = collect($data)
            ->sort(function ($a, $b) {
                return $a['duration'] <= $b['duration'];
            })
            ->take(10)
            ->toArray();

        Winner::insert($sorted);
    }

    private function getTimers($user, $period_date)
    {
        return   Timer::whereHas('city', function ($query) use ($user) {
            return $query->where('country_id', $user->country_id);
        })
            ->where('created_at', '>=', $period_date)
            ->orderBy('duration', 'desc')
            ->get()
            ->groupBy('user_id');
    }
}
