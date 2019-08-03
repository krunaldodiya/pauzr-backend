<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\TimerRepository;
use App\User;
use App\Post;
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
        $user = User::first();
        $post = Post::first();

        $last_timer = Timer::where(['user_id' => $user->id])->orderBy('created_at', 'desc')->first();
        $time_passed_seconds = $last_timer->created_at->diffInSeconds(Carbon::now());

        return compact('user', 'post', 'last_timer', 'time_passed_seconds');
    }
}
