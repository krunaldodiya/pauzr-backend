<?php

namespace App\Policies;

use App\User;
use App\Store;
use Illuminate\Auth\Access\HandlesAuthorization;

class StorePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the store.
     *
     * @param  \App\User  $user
     * @param  \App\Store  $store
     * @return mixed
     */
    public function view(User $user, Store $store)
    {
        return $user->isAdminOrMerchant();
    }

    /**
     * Determine whether the user can create stores.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdminOrMerchant();
    }

    /**
     * Determine whether the user can update the store.
     *
     * @param  \App\User  $user
     * @param  \App\Store  $store
     * @return mixed
     */
    public function update(User $user, Store $store)
    {
        return $user->isAdminOrMerchant();
    }

    /**
     * Determine whether the user can delete the store.
     *
     * @param  \App\User  $user
     * @param  \App\Store  $store
     * @return mixed
     */
    public function delete(User $user, Store $store)
    {
        return $user->isAdminOrMerchant();
    }

    /**
     * Determine whether the user can restore the store.
     *
     * @param  \App\User  $user
     * @param  \App\Store  $store
     * @return mixed
     */
    public function restore(User $user, Store $store)
    {
        return $user->isAdminOrMerchant();
    }

    /**
     * Determine whether the user can permanently delete the store.
     *
     * @param  \App\User  $user
     * @param  \App\Store  $store
     * @return mixed
     */
    public function forceDelete(User $user, Store $store)
    {
        return $user->isAdminOrMerchant();
    }
}
