<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\Category;
use App\Store;
use App\Banner;
use App\Profession;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getInitialData(Request $request)
    {
        $best_offers = Category::with('coupons.store')->where('parent_id', 0)->get();
        $top_brands = Store::where('top_brand', true)->get();
        $banners = Banner::get();

        return ['best_offers' => $best_offers, 'top_brands' => $top_brands, 'banners' => $banners];
    }

    public function getProfessions(Request $request)
    {
        $professions = Profession::get();
        
        return ['professions' => $professions];
    }

    public function getLocations(Request $request)
    {
        $locations = Location::all();
        
        return ['locations' => $locations];
    }

    public function terms(Request $request)
    {
        return view('terms', ['lite' => $request->has('lite')]);
    }
}
