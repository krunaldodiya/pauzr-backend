<?php

namespace App\Repositories;

use App\Repositories\Contracts\CouponRepositoryInterface;
use Carbon\Carbon;
use App\Category;
use App\Coupon;
use App\Store;
use Illuminate\Support\Facades\DB;

class CouponRepository implements CouponRepositoryInterface
{
    public function getAllStores()
    {
        $all_stores = $this->_getAllStores();

        return collect($all_stores)
            ->map(function ($all_store) {
                return [
                    'id' => $all_store->STORE_ID,
                    'name' => $all_store->STORE_NAME,
                    'type' => 'online',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            })
            ->toArray();
    }

    public function getActiveStores()
    {
        $active_stores = $this->_getActiveStores();

        return collect($active_stores)
            ->pluck(['STORE_ID'])
            ->toArray();
    }

    public function updateStores()
    {
        $stores_count = Store::where(['type' => 'online'])->count();

        if ($stores_count == 0) {
            $stores = $this->getAllStores();
            Store::insert($stores);
        }

        Store::where(['type' => 'online'])->update(['active' => false]);
        $active_stores = $this->getActiveStores();
        Store::whereIn('id', $active_stores)->update(['active' => true]);
    }

    public function getCategories()
    {
        $url = $this->_getnerateUrl("getCategories");
        $all_categories = $this->_makeRequest($url);

        return collect($all_categories)->map(function ($all_category) {
            return [
                'id' => $all_category->CAT_ID,
                'parent_id' => $all_category->CAT_PARENT,
                'name' => $all_category->CAT_NAME,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        })->toArray();
    }

    public function updateCategories()
    {
        Category::query()->delete();
        $categories = $this->getCategories();
        Category::insert($categories);
    }

    public function getAllCoupons()
    {
        $all_coupons = $this->_getAllCoupons();

        return $this->getData($all_coupons);
    }

    public function getStoreCoupons($store_id)
    {
        $all_coupons = $this->_getStoreCoupons($store_id);

        return $this->getData($all_coupons);
    }

    public function getData($all_coupons)
    {
        if (!count($all_coupons)) {
            return ['coupons' => null, 'coupon_categories' => null];
        }

        $coupons = [];
        $coupon_categories = [];

        foreach ($all_coupons as $all_coupon) {
            $coupons[] = [
                'id' => $all_coupon->CM_CID,
                'store_id' => $all_coupon->STORE_ID,
                'title' => $all_coupon->TITLE,
                'description' => $all_coupon->DESCRIPTION,
                'coupon' => $all_coupon->COUPON,
                'type' => $all_coupon->TYPE,
                'link' => $all_coupon->LINK,
                'aff_link' => $all_coupon->AFF_LINK,
                'expiry_date' => Carbon::createFromTimestamp($all_coupon->VALIDITY_UNIX),
                'start_date' => Carbon::createFromFormat("Y-m-d", $all_coupon->CREATED_DATE),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $category_ids = explode(",", $all_coupon->FINAL_CAT_LIST);
            foreach ($category_ids as $category_id) {
                if (intval($category_id) > 100) {
                    $coupon_categories[] = ['coupon_id' => $all_coupon->CM_CID, 'category_id' => $category_id];
                }
            }
        }

        return ['coupons' => $coupons, 'coupon_categories' => $coupon_categories];
    }

    public function updateCoupons()
    {
        $coupons_data = $this->getAllCoupons();

        $coupons = $coupons_data['coupons'];
        $coupon_categories = $coupons_data['coupon_categories'];

        $coupon_ids = Coupon::whereHas('store', function ($query) {
            $query->where('type', 'online');
        })->pluck('id');

        Coupon::whereIn('id', $coupon_ids)->delete();
        Coupon::insert($coupons);

        DB::table('category_coupon')->whereIn('coupon_id', $coupon_ids)->delete();
        DB::table('category_coupon')->insert($coupon_categories);
    }

    private function _getStoreCoupons($store_id)
    {
        $url = $this->_getnerateUrl("getStoreCoupons/$store_id");

        return $this->_makeRequest($url);
    }

    private function _getAllCoupons()
    {
        $url = $this->_getnerateUrl("getAllCoupons");

        return $this->_makeRequest($url);
    }

    private function _getAllStores()
    {
        $url = $this->_getnerateUrl("getStores/N");

        return $this->_makeRequest($url);
    }

    private function _getActiveStores()
    {
        $url = $this->_getnerateUrl("getStores/Y");

        return $this->_makeRequest($url);
    }

    private function _getnerateUrl($data)
    {
        $api = env("COUPOMATED_API");

        return "https://www.coupomated.com/apiv3/$api/$data/json";
    }

    private function _makeRequest($url, $type = 'GET')
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request($type, $url);

        return json_decode($response->getBody());
    }
}
