<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Store;
use App\Banner;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Country;
use App\City;
use App\User;

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
        return redirect("https://play.google.com/store/apps/details?id=com.pauzr.org");
    }

    public function getInitialData(Request $request)
    {
        $best_offers = Category::with('coupons.store')->where('parent_id', 0)->get();
        $top_brands = Store::where('top_brand', true)->get();
        $banners = Banner::get();

        return ['best_offers' => $best_offers, 'top_brands' => $top_brands, 'banners' => $banners];
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

    public function notifyError(Request $request)
    {
        return $request->all();
    }

    public function getAssets(Request $request)
    {
        $defaultAsset = $request->url ? $request->url : 'assets/default.png';

        $storageExists = Storage::disk('public')->exists($defaultAsset);

        $assetPath = $storageExists ? public_path("storage/$defaultAsset") : public_path("images/default.png");

        return Image::make($assetPath)->response();
    }
}
