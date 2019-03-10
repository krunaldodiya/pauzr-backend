<?php

namespace App\Policies;

use App\User;
use App\Plan;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlanPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the plan.
     *
     * @param  \App\User  $user
     * @param  \App\Plan  $plan
     * @return mixed
     */
    public function view(User $user, Plan $plan)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create plans.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the plan.
     *
     * @param  \App\User  $user
     * @param  \App\Plan  $plan
     * @return mixed
     */
    public function update(User $user, Plan $plan)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the plan.
     *
     * @param  \App\User  $user
     * @param  \App\Plan  $plan
     * @return mixed
     */
    public function delete(User $user, Plan $plan)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the plan.
     *
     * @param  \App\User  $user
     * @param  \App\Plan  $plan
     * @return mixed
     */
    public function restore(User $user, Plan $plan)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the plan.
     *
     * @param  \App\User  $user
     * @param  \App\Plan  $plan
     * @return mixed
     */
    public function forceDelete(User $user, Plan $plan)
    {
        return $user->isAdmin();
    }
}
