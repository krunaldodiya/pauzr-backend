<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use RobinCSamuel\LaravelMsg91\Facades\LaravelMsg91;

class TestController extends Controller
{
    public function check(Request $request)
    {
        $mobile = $request->mobile;
        $otp =  $request->otp;

        try {
            $data = LaravelMsg91::sendOtp($mobile, $otp, "$otp is Your otp for phone verification.");
            dump($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
