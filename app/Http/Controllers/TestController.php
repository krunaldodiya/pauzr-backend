<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\OtpRepository;

class TestController extends Controller
{
    public $otpRepo;

    public function __construct(OtpRepository $otpRepo)
    {
        $this->otpRepo = $otpRepo;
    }

    public function check(Request $request)
    {
        $type = $request->type ?? "request_otp";
        $mobile = $request->mobile;
        $otp = $request->otp;
        $message = "your otp is $otp";

        if ($type == "request_otp") {
            $response =  $this->otpRepo->sendOtp($mobile, $otp, $message);
        } else {
            $response =  $this->otpRepo->verifyOtp($mobile, $otp);
        }

        return compact('response');
    }
}
