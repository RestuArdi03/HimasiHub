<?php

use App\Http\Controllers\Backend\BackupController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\DiskusiController;
use App\Http\Controllers\FrontendDashboardController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\FrontendKomenController;
use App\Http\Controllers\FrontendAboutController; 
use App\Http\Controllers\FrontendContactController; 
use App\Http\Controllers\FrontendAnggotaController;
use App\Http\Controllers\FrontendKontenController;
use App\Http\Controllers\FrontendBantuanController;
use App\Http\Controllers\FrontendUserController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KomenController;
use App\Http\Controllers\PesanController;
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
    Route::resource('anggota', FrontendAnggotaController::class);
    Route::resource('about', FrontendAboutController::class);
    Route::resource('contact', FrontendContactController::class);
    Route::resource('bantuan', FrontendBantuanController::class);

    // Route Frontend User Profile
    Route::middleware(['auth'])->group(function () {
        Route::resource('user', FrontendUserController::class);
        Route::put('user/password/update', [FrontendUserController::class, 'updatePassword'])->name('user.password.update');
        Route::resource('komen', FrontendKomenController::class);
        Route::resource('pesan', PesanController::class);
    });

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
        Route::get('saldo/report', [SaldoController::class, 'report'])->name('saldo.report');
        Route::resource('saldo', SaldoController::class);

        // ROUTE KAS
        Route::get('kas/{saldo}', [\App\Http\Controllers\KasController::class, 'index'])->name('kas.index');
        Route::post('kas/{saldo}/pay/{member}', [\App\Http\Controllers\KasController::class, 'pay'])->name('kas.pay');
        Route::post('kas/{saldo}/settings', [\App\Http\Controllers\KasController::class, 'updateSettings'])->name('kas.settings');
        Route::delete('kas/unpay/{transaksi}', [\App\Http\Controllers\KasController::class, 'unpay'])->name('kas.unpay');
        Route::post('/kas/{saldo}/reset', [App\Http\Controllers\KasController::class, 'resetKas'])->name('kas.reset');


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
        Route::get('notulen/archive/index', [NotulenController::class, 'archive'])->name('notulen.archive');
        Route::put('notulen/{id}/restore', [NotulenController::class, 'restore'])->name('notulen.restore')->withTrashed();
        Route::delete('notulen/{id}/force-delete', [NotulenController::class, 'forceDelete'])->name('notulen.forceDelete')->withTrashed();
        Route::resource('notulen', NotulenController::class);
        Route::get('notulen/{notulen}/download', [NotulenController::class, 'downloadPdf'])->name('notulen.download');

        // ROUTE KONTEN
        Route::resource('konten', KontenController::class);

        // ROUTE KOMEN
        Route::resource('komen', KomenController::class);

        // ROUTE DISKUSI
        Route::resource('diskusi', DiskusiController::class);
        Route::get('/fetch', [DiskusiController::class, 'fetch'])->name('diskusi.fetch');
        Route::get('/diskusi/fetch-latest', [DiskusiController::class, 'fetchLatest'])->name('diskusi.fetch-latest');
        
        // ROUTE PESAN
        Route::resource('pesan', PesanController::class);
        
        // ROUTE USER
        Route::resource('user', UserController::class);

        // ROUTE BACKUP
        Route::post('/backup/create', [BackupController::class, 'create'])->name('backup.create');
        Route::post('/backup/restore', [BackupController::class, 'restore'])->name('backup.restore');
    });
});

// Route untuk menampilkan halaman kalender
Route::get('/kegiatan/kalender', [KegiatanController::class, 'kalender'])->name('kegiatan.kalender');

// Route API untuk mendapatkan data event
Route::get('/api/kegiatan/events', [KegiatanController::class, 'getEvents'])->name('kegiatan.events');

Route::get('/cek-php', function () {
    phpinfo();
});
