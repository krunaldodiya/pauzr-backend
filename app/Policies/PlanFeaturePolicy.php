<?php

namespace App\Policies;

use App\User;
use App\PlanFeature;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlanFeaturePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the plan feature.
     *
     * @param  \App\User  $user
     * @param  \App\PlanFeature  $planFeature
     * @return mixed
     */
    public function view(User $user, PlanFeature $planFeature)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create plan features.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the plan feature.
     *
     * @param  \App\User  $user
     * @param  \App\PlanFeature  $planFeature
     * @return mixed
     */
    public function update(User $user, PlanFeature $planFeature)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the plan feature.
     *
     * @param  \App\User  $user
     * @param  \App\PlanFeature  $planFeature
     * @return mixed
     */
    public function delete(User $user, PlanFeature $planFeature)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the plan feature.
     *
     * @param  \App\User  $user
     * @param  \App\PlanFeature  $planFeature
     * @return mixed
     */
    public function restore(User $user, PlanFeature $planFeature)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the plan feature.
     *
     * @param  \App\User  $user
     * @param  \App\PlanFeature  $planFeature
     * @return mixed
     */
    public function forceDelete(User $user, PlanFeature $planFeature)
    {
        return $user->isAdmin();
    }
}
