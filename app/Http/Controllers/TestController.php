<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\TimerRepository;
use Illuminate\Support\Facades\Storage;
use App\Post;
use App\User;
use App\Notifications\UserFollowed;
use Illuminate\Support\Facades\Notification;
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
        // $users = User::get();
        // $notification = Notification::locale('es')->send($users, new UserFollowed());

        $user = User::with([
            'city.state.country',
            'state',
            'country',
            'level',
            'wallet',
            'followers.follower_user',
            'followings.following_user',
            'notifications' => function ($query) {
                return $query->where('created_at', '>', Carbon::now()->subDays(30));
            }
        ])
            ->where(['id' => 1])
            ->first();

        dd($user->toArray());
    }
}
