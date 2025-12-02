<?php

namespace App\Policies;

use App\Models\Anggota;
use App\Models\User; // <-- Wajib diimport: User yang sedang login
use Illuminate\Auth\Access\Response;

class AnggotaPolicy
{
    /**
     * Determine whether the user can view any Anggota models.
     */
    // KOREKSI: Parameter pertama harus selalu User $user
    public function viewAny(User $user): bool 
    {
        // ViewAny seringkali boleh untuk semua user yang terautentikasi
        return true; 
    }

    /**
     * Determine whether the user can view the specific Anggota model.
     */
    // KOREKSI: Parameter pertama harus User $user
    public function view(User $user, Anggota $anggota): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create Anggota models.
     */
    // KOREKSI: Pengecekan peran harus pada User $user
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the Anggota model.
     */
    // KOREKSI: Parameter pertama harus User $user, logika pengecekan pada $user
    public function update(User $user, Anggota $anggota): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    // KOREKSI: Parameter pertama harus User $user, logika pengecekan pada $user
    public function delete(User $user, Anggota $anggota): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    // KOREKSI: Parameter pertama harus User $user, logika pengecekan pada $user
    public function restore(User $user, Anggota $anggota): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    // KOREKSI: Parameter pertama harus User $user, logika pengecekan pada $user
    public function forceDelete(User $user, Anggota $anggota): bool
    {
        return $user->hasRole('admin');
    }
}