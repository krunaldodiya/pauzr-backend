<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Timer;

use Carbon\Carbon;

class TimerController extends Controller
{
    public function getPointsHistory(Request $request)
    {
        $user = auth('api')->user();

        $points = $user->wallet->transactions()
            ->whereIn('transaction_type', ['deposit'])
            ->where('status', true)
            ->get();

        $days = $points->last()->created_at->diffInDays($points->first()->created_at) + 1;

        $sum = $points->sum('amount');

        $avg = $sum / $days;

        $history = $points
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->map(function ($item) {
                return [
                    'key' => $this->getPeriod($item),
                    "id" => $item['id'],
                    "wallet_id" => $item['wallet_id'],
                    "user_id" => $item['user_id'],
                    "amount" => $item['amount'],
                    "transaction_id" => $item['transaction_id'],
                    "transaction_type" => $item['transaction_type'],
                    "status" => $item['status'],
                    "meta" => $item['meta'],
                    "created_at" => Carbon::parse($item['created_at'])->diffForHumans(),
                    "updated_at" => $item['updated_at'],
                ];
            })
            ->toArray();

        return compact('history', 'sum', 'avg');
    }

    public function getMinutesHistory(Request $request)
    {
        $user = auth('api')->user();

        $minutes = Timer::where(['user_id' => $user->id])->get();

        $days = $minutes->last()->created_at->diffInDays($minutes->first()->created_at) + 1;

        $sum = $minutes->sum('duration');

        $avg = $sum / $days;

        $history = $minutes
            ->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->map(function ($item) {
                return [
                    'key' => $this->getPeriod($item),
                    "id" => $item['id'],
                    "user_id" => $item['user_id'],
                    "duration" => $item['duration'],
                    "created_at" => Carbon::parse($item['created_at'])->diffForHumans(),
                    "updated_at" => $item['updated_at'],
                ];
            })
            ->toArray();

        return compact('history', 'sum', 'avg');
    }

    private function getPeriod($item)
    {
        $period = [];

        if ($item->created_at >= Carbon::now()->startOfMonth()) {
            $period[] = 'This Month';
        }

        if ($item->created_at >= Carbon::now()->startOfWeek()) {
            $period[] = 'This Week';
        }

        if ($item->created_at >= Carbon::now()->startOfDay()) {
            $period[] = 'Today';
        }

        return $period;
    }
}
