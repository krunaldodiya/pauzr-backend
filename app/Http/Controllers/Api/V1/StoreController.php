<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Product;

use App\Store;

class StoreController extends Controller
{
    public function getStores(Request $request)
    {
        $stores = Store::paginate();

        return compact('stores');
    }

    public function getStoreInfo(Request $request)
    {
        $store = Store::find($request->store_id);

        return compact('store');
    }

    public function getProductsByStore(Request $request)
    {
        $products = Product::where('store_id', $request->store_id)->paginate();

        return compact('products');
    }
}
