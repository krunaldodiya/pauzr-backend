<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\TimerRepository;
use App\User;
use App\Post;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PostLiked;

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

        $post = Post::with('owner', 'likes.user.city', 'earnings')
            ->where(['id' => 1])
            ->first();

        $post->owner->notifications()
            ->where('data->user_id', 1)
            ->where('data->post_id', 1)
            ->delete();

        // $toggle = $user->favorites()->toggle($post);

        // if ($toggle['attached']) {
        //     Notification::send($post->owner, new PostLiked($user->toArray(), $post->toArray()));
        // }

        return 'done';
    }
}
