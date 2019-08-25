<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\TimerRepository;
use App\User;
use App\UserContact;
use Illuminate\Support\Arr;
use App\Post;
use App\Favorite;
use App\Timer;
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
        $lottery = config('lottery');

        $minutes = Timer::where(['user_id' => 1])
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->get()
            ->sum('duration');

        $slopes = [
            ["id" => 1, "min" => 0, "max" => 500],
            ["id" => 2, "min" => 501, "max" => 2000],
            ["id" => 3, "min" => 2001, "max" => 5000],
            ["id" => 4, "min" => 5001, "max" => 10000],
            ["id" => 5, "min" => 10001, "max" => 20000],
        ];

        $current = null;

        foreach ($slopes as $slope) {
            if (($minutes >= $slope['min']) && ($minutes <= $slope['max'])) {
                $current = $lottery[$slope['id']];
            }
        }

        return $current;
    }
}
