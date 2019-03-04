<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Merchant;

class MerchantPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the merchant.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $user, Merchant $merchant)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create merchants.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
        
        // return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the merchant.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $user, Merchant $merchant)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the merchant.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $user, Merchant $merchant)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the merchant.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function restore(User $user, Merchant $merchant)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the merchant.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function forceDelete(User $user, Merchant $merchant)
    {
        return $user->isAdmin();
    }
}
