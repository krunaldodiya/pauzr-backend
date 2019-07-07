<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\TimerRepository;
use App\User;
use App\Winner;
use Carbon\Carbon;
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
        $user = User::find(1);
        $period = "Week";

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

        // Winner::insert($data);


        $sorted = collect($data)
            ->sort(function ($a, $b) {
                return $a['duration'] <= $b['duration'];
            })
            ->take(10)
            ->toArray();

        dd($sorted);
    }
}
