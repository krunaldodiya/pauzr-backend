<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;

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
        $categories = Category::get();
        $stores = Store::where('active', true)->get();

        return ['categories' => $categories, 'stores' => $stores];
    }

    public function terms(Request $request)
    {
        return view('terms', ['lite' => $request->has('lite')]);
    }
}
