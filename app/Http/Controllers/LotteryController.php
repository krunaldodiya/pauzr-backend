<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Arr;

class LotteryController extends Controller
{
    public function getLotteries(Request $request)
    {
        $lottery = config('lottery');

        $shuffled_lottery = Arr::shuffle($lottery[1]);

        return ['lotteries' => $shuffled_lottery];
    }
}
