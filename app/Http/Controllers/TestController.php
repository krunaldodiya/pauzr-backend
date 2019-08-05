<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\TimerRepository;
use App\User;
use App\UserContact;

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
        $user = env('APP_ENV') == "production" ? auth('api')->user() : User::first();

        $already_following = $user->followings->pluck('following_id');

        $post_like_wise = $user->favorites->pluck('user_id');

        $city_wise = User::where('city_id', $user->city->id)->pluck('id');

        $contacts = UserContact::where('user_id', $user->id)->pluck('mobile_cc');

        $contact_wise = User::whereIn('mobile_cc', $contacts)->pluck('id');

        return compact('already_following', 'post_like_wise', 'city_wise', 'contact_wise');
    }
}
