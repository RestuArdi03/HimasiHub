<?php

namespace App\Providers;

use App\Models\Diskusi;
use App\Models\Konten;
use App\Models\Saldo;
use App\Models\Transaksi;
use App\Policies\DiskusiPolicy;
use App\Models\User;
use App\Policies\KontenPolicy;
use App\Policies\SaldoPolicy;
use App\Policies\TransaksiPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Saldo::class => SaldoPolicy::class,
        Transaksi::class => TransaksiPolicy::class,
        Konten::class => KontenPolicy::class,
        Diskusi::class => DiskusiPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Daftarkan Gate untuk setiap aksi
        // Ini memetakan string 'permission' ke metode di dalam Policy
        Gate::define('konten.view', [KontenPolicy::class, 'view']);
        Gate::define('konten.create', [KontenPolicy::class, 'create']);
        Gate::define('konten.update', [KontenPolicy::class, 'update']);
        Gate::define('konten.delete', [KontenPolicy::class, 'delete']);
        Gate::define('konten.restore', [KontenPolicy::class, 'restore']);
        Gate::define('konten.forceDelete', [KontenPolicy::class, 'forceDelete']);

        // Gate untuk membatasi akses hanya untuk Admin
        Gate::define('access-backup', function (User $user) {
            return $user->role->nama_role == 'admin';
        });
    }
}
