<?php

namespace App\Repositories\Contracts;

interface CouponRepositoryInterface
{
    public function getAllStores();
    public function getActiveStores();
    public function getCategories();
    public function getAllCoupons();
    public function getStoreCoupons($store_id);
    public function updateStores();
    public function updateCategories();
    public function updateCoupons();
}

