<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\TimerRepository;
use App\User;
use App\Winner;

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
        $period = $request->period;
        $period_date = $period == 'Week' ? Carbon::now()->startOfWeek() : Carbon::now()->startOfMonth();

        $winners = Winner::with('user')
            ->where(['country_id' => $user->country_id])
            ->where('period', $period)
            ->where('created_at', ">=", $period_date)
            ->orderBy('duration', 'desc')
            ->limit(10)
            ->get();

        return response(['winners' => $winners], 200);
    }
}
