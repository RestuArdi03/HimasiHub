<?php

namespace App\Policies;

use App\Models\Konten;
use App\Models\User;

class KontenPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        // Berikan akses penuh kepada admin
        if ($user->hasRole('admin') || $user->hasRole('sekretaris')) {
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
    public function view(User $user, Konten $konten): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Izinkan jika user adalah admin, sekretaris atau humas
        return $user->hasRole('humas');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Konten $konten): bool
    {
        // Izinkan jika user adalah admin, sekretaris, humas, atau pemilik konten
        return $user->hasRole('humas') || $user->id === $konten->users_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Konten $konten): bool
    {
        return $user->hasRole('humas') || $user->id === $konten->users_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Konten $konten): bool
    {
        return $user->hasRole('humas');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Konten $konten): bool
    {
        return $user->hasRole('humas');
    }
}
