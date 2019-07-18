<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\TimerRepository;
use App\User;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public $userRepository;
    public $timerRepository;

    public function __construct(UserRepository $userRepository, TimerRepository $timerRepository)
    {
        $this->userRepository = $userRepository;
        $this->timerRepository = $timerRepository;
    }

    public function check(Request $request)
    {
        $API_KEY = "5dgRQnLfbglTcwXrmobBceaeE64=";
        $SECRET_KEY = "5dgRQnLfbglTcwXrmobBceaeE64=";
        $IMAGEKIT_ID = "pauzrapp";

        $UPLOAD_API_ENDPOINT = "https://upload.imagekit.io/rest/api/image/v2/$IMAGEKIT_ID";

        $FILENAME = "https://akm-img-a-in.tosshub.com/indiatoday/images/story/201907/super-30_Hrithik_0-770x433.jpeg?nCjjGiayMRUlj08VebELl_d7Ks7XWxQr";
        $file = base64_encode(file_get_contents($FILENAME));

        $TIMESTAMP = strval(time());
        $param_string = "apiKey=$API_KEY&filename=$FILENAME&timestamp=$TIMESTAMP";
        $signature = hash_hmac("sha1", $param_string, $SECRET_KEY);

        $fields = [
            "signature" => $signature,
            "filename" => $FILENAME,
            "timestamp" => $TIMESTAMP,
            "useUniqueFilename" => true,
            "apiKey" => $API_KEY,
            "file" => $file
        ];

        $client = new \GuzzleHttp\Client();
        $response = $client->request("POST", $UPLOAD_API_ENDPOINT, [
            'query' => $fields
        ]);

        return json_decode($response->getBody());
    }
}
