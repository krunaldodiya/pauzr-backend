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
        $post = Post::where(['id' => 60])->first();

        Notification::send($user->followers, new PostCreated($user->toArray(), $post->toArray()));

        return $user;
    }
}
