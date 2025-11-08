<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\SaldoController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('backend.dashboard');
});

Route::get('/backend/dashboard', [DashboardController::class, 'index'])->name('backend.dashboard');

// Route resource saldo
Route::prefix('backend')->name('backend.')->group(function () {
    Route::resource('saldo', SaldoController::class);
});
