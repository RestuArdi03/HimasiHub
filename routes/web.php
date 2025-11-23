<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\FrontendDashboardController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\FrontendKontenController;
use App\Http\Controllers\KontenController;
use App\Http\Controllers\SaldoController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\NotulenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleLoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// =================================================================
// RUTE PUBLIK (FRONTEND)
// =================================================================
Route::get('/', [FrontendDashboardController::class, 'index'])->name('frontend.index');
Route::prefix('frontend')->name('frontend.')->group(function () {
    Route::resource('konten', FrontendKontenController::class);
});

// ROUTE AUTH
Auth::routes();

// Google Login
Route::get('/auth/google/redirect', [GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');

// =================================================================
// RUTE YANG MEMERLUKAN OTENTIKASI (HARUS LOGIN)
// =================================================================
Route::middleware(['auth'])->group(function () {

    // ROUTE BACKEND
    Route::prefix('backend')->name('backend.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // ROUTE SALDO - Rute spesifik harus di atas resource
        Route::get('saldo/trash', [SaldoController::class, 'trash'])->name('saldo.trash');
        Route::put('saldo/{saldo}/restore', [SaldoController::class, 'restore'])->name('saldo.restore')->withTrashed();
        Route::delete('saldo/{saldo}/force-delete', [SaldoController::class, 'forceDelete'])->name('saldo.forceDelete')->withTrashed();
        Route::resource('saldo', SaldoController::class);

        // ROUTE KAS
        Route::get('kas/{saldo}', [\App\Http\Controllers\KasController::class, 'index'])->name('kas.index');
        Route::post('kas/{saldo}/pay/{member}', [\App\Http\Controllers\KasController::class, 'pay'])->name('kas.pay');
        Route::post('kas/{saldo}/settings', [\App\Http\Controllers\KasController::class, 'updateSettings'])->name('kas.settings');
        Route::delete('kas/unpay/{transaksi}', [\App\Http\Controllers\KasController::class, 'unpay'])->name('kas.unpay');

        // ROUTE TRANSAKSI
        Route::get('saldo/{saldo}/transaksi/trash', [TransaksiController::class, 'trash'])->name('transaksi.trash');
        Route::put('transaksi/{id}/restore', [TransaksiController::class, 'restore'])->name('transaksi.restore')->withTrashed();
        Route::delete('transaksi/{id}/force-delete', [TransaksiController::class, 'forceDelete'])->name('transaksi.forceDelete')->withTrashed();
        Route::resource('transaksi', TransaksiController::class)->except(['index', 'show']);

        // ROUTE ANGGOTA
        Route::get('anggota/mantan-anggota', [AnggotaController::class, 'trash'])->name('anggota.trash');
        Route::put('anggota/{id}/restore', [AnggotaController::class, 'restore'])->name('anggota.restore')->withTrashed();
        Route::delete('anggota/{id}/force-delete', [AnggotaController::class, 'forceDelete'])->name('anggota.forceDelete')->withTrashed();
        Route::resource('anggota', AnggotaController::class, ['parameters' => ['anggota' => 'anggota']]);

        // ROUTE NOTULEN
        Route::resource('notulen', NotulenController::class);

        // ROUTE KONTEN
        Route::resource('konten', KontenController::class);
    });
});
