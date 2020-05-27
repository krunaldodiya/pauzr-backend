<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Store;

class StoreController extends Controller
{
    public function getStores(Request $request)
    {
        $categories = Store::get();

        return compact('categories');
    }

    public function getStoreInfo(Request $request)
    {
        $categories = Store::get();

        return compact('categories');
    }

    public function getProductsByStore(Request $request)
    {
        $categories = Store::get();

        return compact('categories');
    }
}
