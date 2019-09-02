<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\GetQuotesCollection;
use App\Quote;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getQuotes(Request $request)
    {
        $quotes = Quote::orderBy('order', 'asc')->get();

        return new GetQuotesCollection($quotes);
    }
}
