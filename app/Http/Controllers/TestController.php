<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\TimerRepository;
use Illuminate\Support\Facades\Storage;
use App\Post;

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
        $post = Post::with('likes')->first();

        return compact('post');
    }
}
