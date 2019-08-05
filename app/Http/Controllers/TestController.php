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
        // $user = auth('api')->user();
        $user = User::first();

        $already_following = $user->followings->pluck('following_id');

        $post_like_wise = $user->favorites->pluck('user_id');

        $city_wise = User::where('city_id', $user->city->id)->pluck('id');

        $contact_wise = UserContact::where('user_id', $user->id)->pluck('mobile_cc');

        return compact('already_following', 'post_like_wise', 'city_wise', 'contact_wise');
    }
}
