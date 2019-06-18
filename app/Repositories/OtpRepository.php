<?php

namespace App\Repositories;

use App\Repositories\Contracts\OtpRepositoryInterface;
use PhpParser\Error;
use App\Exceptions\OtpFailed;

class OtpRepository implements OtpRepositoryInterface
{
    private function generateUrl($type, $mobile, $otp, $message)
    {
        $base_url = "https://control.msg91.com/api";
        $authKey = config('msg91.auth_key');

        if ($type == 'request_otp') {
            return "$base_url/sendotp.php?authkey=$authKey&mobile=$mobile&otp=$otp&message=$message";
        }

        if ($type == 'verify_otp') {
            return "$base_url/verifyRequestOTP.php?authkey=$authKey&mobile=$mobile&otp=$otp";
        }
    }

    public function sendOtp($mobile, $otp, $message)
    {
        $url = $this->generateUrl("request_otp", $mobile, $otp, $message);

        $client = new \GuzzleHttp\Client();

        $response = $client->get($url);

        $body = json_decode($response->getBody());

        if ($body->type == "success") {
            return true;
        }

        throw new OtpFailed($body->message);
    }

    public function verifyOtp($mobile, $otp)
    {
        $url = $this->generateUrl("verify_otp", $mobile, $otp, null);

        $client = new \GuzzleHttp\Client();

        $response = $client->get($url);

        $body = json_decode($response->getBody());

        if ($body->type == "success") {
            return true;
        }

        throw new OtpFailed($body->message);
    }
}
