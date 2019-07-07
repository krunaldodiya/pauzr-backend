<?php

namespace App\Repositories;

use App\Repositories\Contracts\TimerRepositoryInterface;

use Carbon\Carbon;
use App\Timer;
use App\Winner;

class TimerRepository implements TimerRepositoryInterface
{
    public function calculateWinners($user, $period)
    {
        $period_date = $period == 'Week' ? Carbon::now()->startOfWeek() : Carbon::now()->startOfMonth();

        Winner::where('country_id', $user->country_id)
            ->where('period', $period)
            ->where('created_at', '>=', $period_date)
            ->delete();

        $timers = Timer::whereHas('city', function ($query) use ($user) {
            return $query->where('country_id', $user->country_id);
        })
            ->where('created_at', '>=', $period_date)
            ->orderBy('duration', 'desc')
            ->get()
            ->groupBy('user_id');

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
}
