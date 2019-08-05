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
        $user = User::first();

        $already_following = $user->followings->pluck('following_id');

        $post_like_wise = $user->favorites->pluck('user_id');
        $city_wise = User::where('city_id', $user->city->id)->pluck('id');
        $contact_wise = UserContact::where('user_id', $user->id)->pluck('mobile_cc');

        $followable_users = User::where(function ($query) use ($post_like_wise, $city_wise, $contact_wise) {
            return $query
                ->whereIn('id', $post_like_wise)
                ->orWhereIn('id', $city_wise)
                ->orWhereIn('mobile_cc', $contact_wise);
        })
            ->whereNotIn('id', $already_following)
            ->get();

        return compact('post_like_wise', 'city_wise', 'contact_wise', 'followable_users');
    }
}
