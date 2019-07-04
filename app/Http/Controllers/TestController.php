<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\TimerRepository;
use Carbon\Carbon;
use App\User;
use App\Timer;

class TestController extends Controller
{
    public $userRepository;
    public $timerRepository;

    public function __construct(UserRepository $userRepository, TimerRepository $timerRepository)
    {
        $this->userRepository = $userRepository;
        $this->timerRepository = $timerRepository;
    }

    public function check(Request $request)
    {
        $user = User::find(2);

        $duration = 'Week';
        $period = $duration == 'Week' ? Carbon::now()->startOfWeek() : Carbon::now()->startOfMonth();

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

        $data = collect($data)
            ->sort('minutes', 'desc')
            ->take(10)
            ->toArray();

        return $data;
    }
}
