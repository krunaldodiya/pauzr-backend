<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\GetWinnersCollection;
use Illuminate\Http\Request;

use App\Lottery;

class LotteryController extends Controller
{
    public function getWinners(Request $request)
    {
        $winners = Lottery::with('user')
            ->where('type', 'credited')
            ->where('amount', '>', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(30);

        return new GetWinnersCollection($winners);
    }
}
