<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Timer;
use App\User;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function check(Request $request)
    {
        return 'test';

        // return $this->test($request);
    }

    public function test($request)
    {
        if (!$request->user_id) {
            return [
                "User ID is required"
            ];
        }

        $user = User::find($request->user_id);

        $dates = [];

        for ($i = 0; $i <= 30; $i++) {
            $dates[] = Carbon::now()->subDay($i);
        }

        $items = [
            ["time" => "20", "point" => "1"],
            ["time" => "40", "point" => "3"],
            ["time" => "60", "point" => "5"]
        ];

        foreach ($dates as $date) {
            foreach ($items as $item) {
                $timer = Timer::create([
                    'user_id' => $user->id,
                    'duration' => $item['time'],
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);

                $transaction = $user->createTransaction($item['point'], 'deposit', ['description' => "Earned points of TIMER_ID #${timer}"]);
                $user->deposit($transaction->transaction_id);
            }
        }

        return $timer;
    }
}
