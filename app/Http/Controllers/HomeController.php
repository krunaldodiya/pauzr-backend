<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use App\Category;
use App\Store;
use App\Banner;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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

    public function getLocations(Request $request)
    {
        $locations = Location::get();

        return ['locations' => $locations];
    }

    public function getInitialData(Request $request)
    {
        $top_categories = Category::with('stores')->where('parent_id', 0)->get();
        $top_brands = Store::where('top_brand', true)->get();
        $banners = Banner::get();

        return ['top_categories' => $top_categories, 'top_brands' => $top_brands, 'banners' => $banners];
    }

    public function terms(Request $request)
    {
        return view('terms', ['lite' => $request->has('lite')]);
    }
}
