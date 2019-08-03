<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\TimerRepository;
use App\User;
use App\Timer;
use Carbon\Carbon;

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
        $user = User::where(['id' => 1])->first();

        $duration = "20";
        $duration_seconds = $duration * 60;

        $last_timer = Timer::where(['user_id' => $user->id])->orderBy('created_at', 'desc')->first();
        $time_passed_seconds = $last_timer ? $last_timer->created_at->diffInSeconds(Carbon::now()) : 3600;

        if ($time_passed_seconds >= $duration_seconds) {
            $user = $this->timerRepository->setTimer($user, $duration);
            return ['user' => $this->userRepository->getUserById($user->id)];
        }

        return response(['error' => "Invalid Request"], 403);
    }
}
