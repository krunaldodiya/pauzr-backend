<?php

namespace App\Repositories;

use App\Repositories\Contracts\TimerRepositoryInterface;

use Carbon\Carbon;
use App\Timer;
use App\Winner;

class TimerRepository implements TimerRepositoryInterface
{
    public function calculateWinners($user, $duration)
    {
        $period = $duration == 'Week' ? Carbon::now()->startOfWeek() : Carbon::now()->startOfMonth();

        Winner::where('country_id', $user->country_id)
            ->where('created_at', '>=', $period)
            ->delete();

        $timers = Timer::whereHas('city', function ($query) use ($user) {
            return $query->where('country_id', $user->country_id);
        })
            ->where('created_at', '>=', $period)
            ->orderBy('duration', 'desc')
            ->get()
            ->groupBy('user_id');

        $data = [];

        foreach ($timers as $user_id => $timer) {
            $data[] = [
                'country_id' => $user->country_id,
                'user_id' => $user_id,
                'minutes' => $timer->sum('duration'),
                'duration' => $duration,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        Winner::insert($data);
    }
}
