<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Arr;
use App\Lottery;
use App\Timer;
use Carbon\Carbon;

use Exception;

class LotteryController extends Controller
{
    public function getLotteryWinners(Request $request)
    {
        $lottery_winners = Lottery::with('user.city')
            ->where('amount', '>', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        return ['lottery_winners' => $lottery_winners];
    }

    public function getLotteries(Request $request)
    {
        $user = auth('api')->user();

        $lottery = $this->getLotterySlope($user);

        $earnings = Lottery::where(['user_id' => $user->id])
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->get()
            ->sum('amount');

        $selectedLotteryIndex = $request->selectedLotteryIndex;

        if ($user->wallet->balance >= 1000) {
            return $this->generateLottery($user, $lottery, $selectedLotteryIndex, $earnings);
        }

        throw new Exception("Insufficient balance", 403);
    }

    private function generateLottery($user, $lottery, $selectedLotteryIndex, $earnings)
    {
        $shuffled_lottery = Arr::shuffle($lottery);

        if ($earnings == 0) {
            $replacements = array($selectedLotteryIndex => 5);

            $shuffled_lottery = array_replace($shuffled_lottery, $replacements);
        }

        $amount = $shuffled_lottery[$selectedLotteryIndex];

        Lottery::create(['amount' => $amount, 'user_id' => $user->id]);

        $transaction = $user->createTransaction(20, 'withdraw', ['description' => "Purchased Lottery"]);
        $user->withdraw($transaction->transaction_id);

        return ['lotteries' => $shuffled_lottery];
    }

    private function getLotterySlope($user)
    {
        $lottery = config('lottery');

        $minutes = Timer::where(['user_id' => $user->id])
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->get()
            ->sum('duration');

        if (($minutes >= 0) && ($minutes <= 500)) {
            return $lottery[1];
        }

        if (($minutes >= 501) && ($minutes <= 2000)) {
            return $lottery[2];
        }

        if (($minutes >= 2001) && ($minutes <= 5000)) {
            return $lottery[3];
        }

        if (($minutes >= 5001) && ($minutes <= 10000)) {
            return $lottery[4];
        }

        if (($minutes >= 10001) && ($minutes <= 20000)) {
            return $lottery[5];
        }
    }
}
