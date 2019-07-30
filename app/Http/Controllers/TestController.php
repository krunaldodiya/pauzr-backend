<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\TimerRepository;
use JD\Cloudder\Facades\Cloudder;
use App\Quote;
use Illuminate\Support\Arr;
use App\User;
use Carbon\Carbon;
use App\Image;

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
        $users = User::where('avatar', '!=', null)->get()->map(function ($user) {
            return [
                'user_id' => $user->id,
                'url' => $user->avatar,
                'default' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        })->toArray();

        $create = Image::insert($users);

        return 'okay';
    }
}
