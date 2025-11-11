<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\SaldoController;
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
Route::get('/', function () {
    return view('frontend.dashboard'); // Asumsi file ini ada
})->name('frontend.index');

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

        // ROUTE SALDO
        Route::resource('saldo', SaldoController::class);
        Route::put('saldo/{saldo}/restore', [SaldoController::class, 'restore'])->name('saldo.restore');
        Route::delete('saldo/{saldo}/force-delete', [SaldoController::class, 'forceDelete'])->name('saldo.forceDelete');
        Route::get('saldo/trash', [SaldoController::class, 'trash'])->name('saldo.trash');

        // ROUTE ANGGOTA
        Route::resource('anggota', AnggotaController::class);
    });
});
