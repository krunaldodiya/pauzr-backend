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
        $stores = Store::get();

        return compact('stores');
    }

    public function getStoreInfo(Request $request)
    {
        $store = Store::with('category')
            ->where('id', $request->store_id)
            ->first();

        return compact('store');
    }

    public function getProductsByStore(Request $request)
    {
        $products = Product::with('images', 'store')
            ->where('store_id', $request->store_id)
            ->paginate();

        return compact('products');
    }
}
