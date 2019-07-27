<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Arr;
use App\Lottery;
use App\Timer;
use Carbon\Carbon;

class LotteryController extends Controller
{
    public function getLotteryWinners(Request $request)
    {
        $lottery_winners = Lottery::with('user.city')
            ->where('type', 'credited')
            ->where('amount', '>', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        return ['lottery_winners' => $lottery_winners];
    }

    public function getLotteryHistory(Request $request)
    {
        $user = auth('api')->user();

        $lottery_history = Lottery::with('user.city')
            ->where('user_id', $user->id)
            ->where('amount', '>', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        $credited = $lottery_history->where('type', 'credited')->sum('amount');
        $debited = $lottery_history->where('type', 'debited')->sum('amount');
        $total = $credited - $debited;

        return ['lottery_history' => $lottery_history, 'total' => $total];
    }

    public function getLotteries(Request $request)
    {
        $user = auth('api')->user();

        $lottery = $this->getLotterySlope($user);

        $earnings = Lottery::with('user.city')
            ->where('type', 'credited')
            ->where(['user_id' => $user->id])
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->get()
            ->sum('amount');

        $selectedLotteryIndex = $request->selectedLotteryIndex;

        if ($user->wallet->balance >= 20) {
            return $this->generateLottery($user, $lottery, $selectedLotteryIndex, $earnings);
        }

        return ['lotteries' => null, 'wallet' => $user->wallet];
    }

    private function generateLottery($user, $lottery, $selectedLotteryIndex, $earnings)
    {
        $shuffled_lottery = $this->getFinalShuffled($lottery, $selectedLotteryIndex, $earnings);

        if ($earnings == 0) {
            $replacements = array($selectedLotteryIndex => 5);
            $shuffled_lottery = array_replace($shuffled_lottery, $replacements);
        }

        Lottery::create([
            'amount' => $shuffled_lottery[$selectedLotteryIndex],
            'user_id' => $user->id,
            'type' => 'credited'
        ]);

        $transaction = $user->createTransaction(20, 'withdraw', ['description' => "Purchased Lottery"]);
        $user = $user->withdraw($transaction->transaction_id);

        return ['lotteries' => $shuffled_lottery, 'wallet' => $user->wallet];
    }

    private function getFinalShuffled($lottery, $selectedLotteryIndex, $earnings)
    {
        $shuffled_lottery = Arr::shuffle($lottery);

        $amount = $shuffled_lottery[$selectedLotteryIndex];

        if (($earnings + $amount) <= 200) {
            return $shuffled_lottery;
        }

        return $this->getFinalShuffled($lottery, $selectedLotteryIndex, $earnings);
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
