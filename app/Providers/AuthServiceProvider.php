<?php

namespace App\Providers;

use App\Models\Konten;
use App\Models\Saldo;
use App\Models\Transaksi;
use App\Policies\KontenPolicy;
use App\Policies\SaldoPolicy;
use App\Policies\TransaksiPolicy;
// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
