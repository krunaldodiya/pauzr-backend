<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Arr;
use App\Lottery;

class LotteryController extends Controller
{
    public function getLotteries(Request $request)
    {
        $user = auth('api')->user();

        $lottery = config('lottery');

        $shuffled_lottery = Arr::shuffle($lottery[5]);

        $amount = $shuffled_lottery[$request['selectedLotteryIndex']];

        Lottery::create(['amount' => $amount, 'user_id' => $user->id]);

        return ['lotteries' => $shuffled_lottery];
    }

    public function getLotteryWinners(Request $request)
    {
        $lottery_winners = Lottery::with('user.city')->get();

        return ['lottery_winners' => $lottery_winners];
    }
}
