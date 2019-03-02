<?php

namespace App\Policies;

use App\User;
use App\Coupon;
use Illuminate\Auth\Access\HandlesAuthorization;

class CouponPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the coupon.
     *
     * @param  \App\User  $user
     * @param  \App\Coupon  $coupon
     * @return mixed
     */
    public function view(User $user, Coupon $coupon)
    {
        //
    }

    /**
     * Determine whether the user can create coupons.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the coupon.
     *
     * @param  \App\User  $user
     * @param  \App\Coupon  $coupon
     * @return mixed
     */
    public function update(User $user, Coupon $coupon)
    {
        //
    }

    /**
     * Determine whether the user can delete the coupon.
     *
     * @param  \App\User  $user
     * @param  \App\Coupon  $coupon
     * @return mixed
     */
    public function delete(User $user, Coupon $coupon)
    {
        //
    }

    /**
     * Determine whether the user can restore the coupon.
     *
     * @param  \App\User  $user
     * @param  \App\Coupon  $coupon
     * @return mixed
     */
    public function restore(User $user, Coupon $coupon)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the coupon.
     *
     * @param  \App\User  $user
     * @param  \App\Coupon  $coupon
     * @return mixed
     */
    public function forceDelete(User $user, Coupon $coupon)
    {
        //
    }
}
