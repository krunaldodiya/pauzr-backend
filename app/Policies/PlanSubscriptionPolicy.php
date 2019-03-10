<?php

namespace App\Policies;

use App\User;
use App\PlanSubscription;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlanSubscriptionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the plan subscription.
     *
     * @param  \App\User  $user
     * @param  \App\PlanSubscription  $planSubscription
     * @return mixed
     */
    public function view(User $user, PlanSubscription $planSubscription)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create plan subscriptions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can update the plan subscription.
     *
     * @param  \App\User  $user
     * @param  \App\PlanSubscription  $planSubscription
     * @return mixed
     */
    public function update(User $user, PlanSubscription $planSubscription)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the plan subscription.
     *
     * @param  \App\User  $user
     * @param  \App\PlanSubscription  $planSubscription
     * @return mixed
     */
    public function delete(User $user, PlanSubscription $planSubscription)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the plan subscription.
     *
     * @param  \App\User  $user
     * @param  \App\PlanSubscription  $planSubscription
     * @return mixed
     */
    public function restore(User $user, PlanSubscription $planSubscription)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the plan subscription.
     *
     * @param  \App\User  $user
     * @param  \App\PlanSubscription  $planSubscription
     * @return mixed
     */
    public function forceDelete(User $user, PlanSubscription $planSubscription)
    {
        return $user->isAdmin();
    }
}
