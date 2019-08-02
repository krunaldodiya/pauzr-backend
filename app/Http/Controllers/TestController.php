<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\TimerRepository;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PostLiked;
use App\Notifications\PostCreated;
use Illuminate\Support\Carbon;

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

        return compact('user', 'post');
    }
}
