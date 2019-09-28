<?php

namespace App\Http\Controllers;

use App\Lottery;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\TimerRepository;
use App\User;
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
        $user = User::find(1572);

        $getLotterySlope = $this->getLotterySlope($user);

        $lotteries = $getLotterySlope['lotteries'];
        $max_redeem = $getLotterySlope['max_redeem'];

        $earnings = Lottery::with('user.city')
            ->where('type', 'credited')
            ->where(['user_id' => $user->id])
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->get()
            ->sum('amount');

        dump($lotteries);
        dump($max_redeem);
        dd($earnings);
    }

    private function getLotterySlope($user)
    {
        $lottery = config('lottery');

        $minutes = Timer::where(['user_id' => $user->id])
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->get()
            ->sum('duration');

        $slopes = [
            ["id" => 1, "min" => 0, "max" => 200],
            ["id" => 2, "min" => 201, "max" => 1000],
            ["id" => 3, "min" => 1001, "max" => 2000],
            ["id" => 4, "min" => 2001, "max" => 5000],
            ["id" => 5, "min" => 5001, "max" => 20000],
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
