<?php

namespace App\Policies;

use App\Models\Test;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the test can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list tests');
    }

    /**
     * Determine whether the test can view the model.
     */
    public function view(User $user, Test $model): bool
    {
        return $user->hasPermissionTo('view tests');
    }

    /**
     * Determine whether the test can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create tests');
    }

    /**
     * Determine whether the test can update the model.
     */
    public function update(User $user, Test $model): bool
    {
        return $user->hasPermissionTo('update tests');
    }

    /**
     * Determine whether the test can delete the model.
     */
    public function delete(User $user, Test $model): bool
    {
        return $user->hasPermissionTo('delete tests');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete tests');
    }

    /**
     * Determine whether the test can restore the model.
     */
    public function restore(User $user, Test $model): bool
    {
        return false;
    }

    /**
     * Determine whether the test can permanently delete the model.
     */
    public function forceDelete(User $user, Test $model): bool
    {
        return false;
    }
}
