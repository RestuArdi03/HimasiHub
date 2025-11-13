<?php

namespace App\Policies;

use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TransaksiPolicy
{
    /**
     * Perform pre-authorization checks.
     */
    public function before(User $user, string $ability): bool|null
    {
        // Berikan akses penuh kepada admin
        if ($user->hasRole('admin')) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Izinkan jika user memiliki role Bendahara
        return $user->hasRole('admin') || $user->hasRole('bendahara');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Transaksi $transaksi): bool
    {
        // Izinkan jika user memiliki role Bendahara
        return $user->hasRole('admin') || $user->hasRole('bendahara');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Transaksi $transaksi): bool
    {
        // Izinkan jika user memiliki role Bendahara
        return $user->hasRole('admin') || $user->hasRole('bendahara');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Transaksi $transaksi): bool
    {
        return $user->hasRole('admin') || $user->hasRole('bendahara');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Transaksi $transaksi): bool
    {
        return $user->hasRole('admin') || $user->hasRole('bendahara');
    }
}
