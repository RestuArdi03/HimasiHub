<?php

namespace App\Policies;

use App\Models\KalenderKegiatan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KalenderKegiatanPolicy
{
    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @return bool|null
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, KalenderKegiatan $kalenderKegiatan): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole(['admin', 'humas']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, KalenderKegiatan $kalenderKegiatan): bool
    {
        return $user->hasAnyRole(['admin', 'humas']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, KalenderKegiatan $kalenderKegiatan): bool
    {
        return $user->hasAnyRole(['admin', 'humas']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, KalenderKegiatan $kalenderKegiatan): bool
    {
        return $user->hasAnyRole(['admin', 'humas']);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, KalenderKegiatan $kalenderKegiatan): bool
    {
        return $user->hasAnyRole(['admin', 'humas']);
    }
}
