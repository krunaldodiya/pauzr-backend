<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Arr;
use App\Lottery;

class LotteryController extends Controller
{
    public function getLotteries(Request $request)
    {
        $lottery = config('lottery');

        $shuffled_lottery = Arr::shuffle($lottery[5]);

        return ['lotteries' => $shuffled_lottery];
    }

    public function getLotteryWinners(Request $request)
    {
        $lottery_winners = Lottery::with('user')->get();

        return ['lottery_winners' => $lottery_winners];
    }
}
