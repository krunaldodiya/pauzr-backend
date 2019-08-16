<?php

namespace App\Http\Controllers\Api\V1;

use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\GetCountriesResource;

class LocationController extends Controller
{
    public function getCountries(Request $request)
    {
        $countries = Country::get();

        return new GetCountriesResource($countries);
    }
}
