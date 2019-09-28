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
            ->paginate(100);

        return ['lottery_winners' => $lottery_winners];
    }

    public function getLotteryHistory(Request $request)
    {
        $user = auth('api')->user();

        $lottery_history = Lottery::where('user_id', $user->id)
            ->where('amount', '>', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        $credited = $lottery_history->where('type', 'credited')->sum('amount');
        $debited = $lottery_history->where('type', 'debited')->sum('amount');
        $total = $credited - $debited;

        return ['lottery_history' => $lottery_history, 'total' => $total];
    }

    public function withdrawAmount(Request $request)
    {
        $user = auth('api')->user();
        $amount = $request->amount;

        Lottery::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'type' => 'debited',
            'status' => 'pending'
        ]);

        return response(['success' => true], 200);
    }

    public function getLotteries(Request $request)
    {
        $user = auth('api')->user();

        $getLotterySlope = $this->getLotterySlope($user);

        $lotteries = $getLotterySlope['lotteries'];
        $max_redeem = $getLotterySlope['max_redeem'];

        $earnings = Lottery::with('user.city')
            ->where('type', 'credited')
            ->where(['user_id' => $user->id])
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->get()
            ->sum('amount');

        $selectedLotteryIndex = $request->selectedLotteryIndex;

        if ($user->wallet->balance >= 20) {
            return $this->generateLottery($user, $lotteries, $max_redeem, $selectedLotteryIndex, $earnings);
        }

        return ['lotteries' => null, 'wallet' => $user->wallet];
    }

    private function generateLottery($user, $lotteries, $max_redeem, $selectedLotteryIndex, $earnings)
    {
        $shuffled_lottery = $this->getFinalShuffled($lotteries, $max_redeem, $selectedLotteryIndex, $earnings);

        if ($earnings == 0) {
            $replacements = array($selectedLotteryIndex => 5);
            $shuffled_lottery = array_replace($shuffled_lottery, $replacements);
        }

        Lottery::create([
            'amount' => $shuffled_lottery[$selectedLotteryIndex],
            'user_id' => $user->id,
            'type' => 'credited',
            'status' => 'success'
        ]);

        $transaction = $user->createTransaction(20, 'withdraw', ['description' => "Purchased Lottery"]);
        $user = $user->withdraw($transaction->transaction_id);

        return ['lotteries' => $shuffled_lottery, 'wallet' => $user->wallet];
    }

    private function getFinalShuffled($lotteries, $max_redeem, $selectedLotteryIndex, $earnings)
    {
        $shuffled_lottery = Arr::shuffle($lotteries);

        $amount = $shuffled_lottery[$selectedLotteryIndex];

        if (($earnings + $amount) <= $max_redeem) {
            return $shuffled_lottery;
        }

        return $this->getFinalShuffled($lotteries, $max_redeem, $selectedLotteryIndex, $earnings);
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
            ["id" => 5, "min" => 5001, "max" => 200000],
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
