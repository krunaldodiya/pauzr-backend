<?php

namespace App\Http\Controllers;

use Exception;

use App\Http\Requests\RequestOtp;
use App\Http\Requests\VerifyOtp;
use App\Exceptions\OtpFailed;
use App\Repositories\UserRepository;
use App\Repositories\OtpRepository;

class OtpController extends Controller
{
    public $userRepo;
    public $otpRepo;

    public function __construct(UserRepository $userRepo, OtpRepository $otpRepo)
    {
        $this->userRepo = $userRepo;
        $this->otpRepo = $otpRepo;
    }

    protected function otpAuth($country, $mobile, $otp, $type, $production)
    {
        $app_name = config('app.name');

        $mobileWithPC = "{$country['phonecode']} $mobile";

        if ($type == 'request') {
            if ($production == true) {
                return $this->otpRepo->sendOtp($mobileWithPC, $otp, "$otp is Your otp for phone verification for $app_name.");
            }

            if ($production == false) {
                return response(['otp' => $otp], 200);
            }
        }

        if ($type == 'verify') {
            if ($production == true) {
                return $this->otpRepo->verifyOtp($mobileWithPC, $otp);
            }

            if ($production == false) {
                if ($otp != 1234) {
                    throw new OtpFailed("Invalid OTP");
                }

                return response(['message' => 'otp_verified'], 200);
            }
        }
    }

    public function requestOtp(RequestOtp $request)
    {
        $production = env('APP_ENV') == 'production';

        $country = $request->country;
        $mobile = $request->mobile;
        $otp = $production ? mt_rand(1000, 9999) : 1234;

        try {
            $requestOtp = $this->otpAuth($country, $mobile, $otp, 'request', $production);

            return $requestOtp ? ['mobile' => $mobile, 'otp' => $otp] : false;
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function verifyOtp(VerifyOtp $request)
    {
        $production = env('APP_ENV') == 'production';

        $country = $request->country;
        $mobile = $request->mobile;
        $otp = $request->otp;

        try {
            $this->otpAuth($country, $mobile, $otp, 'verify', $production);
            return $this->userRepo->otpAuth($request);
        } catch (Exception $e) {
            return response(['errors' => ['otp' => [$e->getMessage()]]], 400);
        }
    }
}
