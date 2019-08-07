<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\TimerRepository;
use App\User;
use App\UserContact;
use Illuminate\Support\Arr;

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
        $user = User::with([
            'posts' => function ($query) {
                return $query->paginate(10);
            },
            'posts.likes' => function ($query) {
                return $query->paginate(1);
            },
            'posts.likes.user'
        ])
            ->where(['email' => 'kunal.dodiya1@gmail.com'])
            ->first();

        return compact('user');
    }
}
