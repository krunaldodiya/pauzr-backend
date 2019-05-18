<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;

class TestController extends Controller
{
    public function check(Request $request)
    {
        return $this->test($request);
    }

    public function filterPeriod($period)
    {
        if ($period == 'Today') {
            return Carbon::now()->startOfDay();
        }

        if ($period == 'This Week') {
            return Carbon::now()->startOfWeek();
        }

        if ($period == 'This Month') {
            return Carbon::now()->startOfMonth();
        }
    }

    public function test($request)
    {
        if (!$request->user_id) {
            return [
                "User ID is required"
            ];
        }

        $user = User::find($request->user_id);

        return $user;
    }
}
