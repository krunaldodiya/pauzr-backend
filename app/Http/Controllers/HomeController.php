<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Store;
use App\Banner;
use Intervention\Image\Facades\Image;
use App\Country;
use App\City;
use App\User;
use App\Invitation;
use Illuminate\Support\Str;
use App\Quote;
use Illuminate\Support\Arr;
use App\Refer;
use Jenssegers\Agent\Agent;
use function GuzzleHttp\json_encode;
use App\AdKeyword;
use App\AdImpression;
use App\PushNotification;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function __construct()
    {
        //
    }

    public function home()
    {
        return view('home');
    }

    public function exportUsers()
    {
        return User::pluck('fcm_token');
    }

    public function checkInvitation(Request $request)
    {
        $sender_id = $request->segment(3);
        $mobile_cc = $request->segment(4);

        $exists = Invitation::where(['mobile_cc' => $mobile_cc])->first();

        if (!$exists) {
            Invitation::create([
                'sender_id' => $sender_id,
                'mobile_cc' => $mobile_cc
            ]);
        }

        return redirect("https://play.google.com/store/apps/details?id=com.pauzr.org");
    }

    public function getAdsKeywords(Request $request)
    {
        $keywords = AdKeyword::pluck('keywords')->toArray();

        return response(compact('keywords'), 200);
    }

    public function setAdImpression(Request $request)
    {
        $user = auth('api')->user();

        $impression = AdImpression::create([
            'user_id' => $user->id,
            'type' => $request->type,
        ]);

        return response(compact('impression'), 200);
    }

    public function getRefer(Request $request)
    {
        $agent = new Agent();

        $data = [
            'utm' => $request->utm,
            'ip_address' => $request->ip(),
            'languages' => json_encode($agent->languages()),
            'device' => $agent->device(),
            'platform' => $agent->platform(),
            'platform_version' => $agent->version($agent->platform()),
            'browser' => $agent->browser(),
            'browser_version' => $agent->version($agent->browser()),
            'robot' => $agent->robot(),
        ];

        Refer::create($data);

        return redirect("https://play.google.com/store/apps/details?id=com.pauzr.org");
    }

    public function getInitialData(Request $request)
    {
        $best_offers = Category::with('coupons.store')->where('parent_id', 0)->get();
        $top_brands = Store::where('top_brand', true)->get();
        $banners = Banner::get();

        return ['best_offers' => $best_offers, 'top_brands' => $top_brands, 'banners' => $banners];
    }

    public function getQuotes(Request $request)
    {
        $quotes = Quote::orderBy('order', 'asc')->get();

        $first_array = $quotes[0];

        unset($quotes[0]);

        $other_quotes = array_values($quotes->toArray());

        $shuffled_quotes = Arr::shuffle($other_quotes);

        $random_quotes = array_merge([$first_array->toArray()], $shuffled_quotes);

        return ['quotes' => $random_quotes];
    }

    public function getCountries(Request $request)
    {
        $countries = Country::get();

        return ['countries' => $countries];
    }

    public function getCities(Request $request)
    {
        $user = auth('api')->user();

        $cities = City::with('state')
            ->where('country_id', $user->country_id)
            ->get();

        return ['cities' => $cities];
    }

    public function terms(Request $request)
    {
        return view('terms', ['lite' => $request->has('lite')]);
    }

    public function privacy(Request $request)
    {
        return view('privacy');
    }

    public function getAssets(Request $request)
    {
        if (Str::contains($request->url, 'https://')) {
            return Image::make($request->url)->response();
        }

        return Image::make(public_path("images/default.png"))->response();
    }

    public function deployPush(Request $request)
    {
        $push_notification_id = $request->push_notification_id;

        $push_notification = PushNotification::with('subscribers')
            ->where(['id' => $push_notification_id])
            ->first();

        $subscribers = $push_notification->subscribers->map(function ($subscriber) {
            return $subscriber['subscriber_id'];
        });

        $registration_ids = User::whereIn('id', $subscribers)->pluck('fcm_token');

        $title = $push_notification['title'];
        $description = $push_notification['description'];
        $image = Storage::disk('public')->url($push_notification['image']);

        $data = [
            'title' => $title,
            'body' => strip_tags($description),
            'image'  => $image,
        ];

        try {
            $url = "https://fcm.googleapis.com/fcm/send";
            $client = new \GuzzleHttp\Client();
            $response = $client->request("POST", $url, [
                'headers' => [
                    'Authorization' => 'key=AAAAPJZ0LFc:APA91bFlF0ToRbgnP8C8RxseGvvk0gralYQqUTVU-ZBV-OWoBIVY79CIU3bS6O4TIYHW-Sx6g-KoijIcmLPIoHNiXAz2rFFM1Hv7rUawuGyo3ghoKc1-sLFDAt3LUQDSTnxs_CDmL-yV'
                ],
                'json' => [
                    'registration_ids' => $registration_ids,
                    'notification' => $data,
                    'data' => $data,
                ]
            ]);

            $push_notification = PushNotification::where(['id' => $push_notification_id])
                ->update(['status' => true, 'response' => $response->getBody()]);

            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
