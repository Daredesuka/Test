<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PelaporanController;
use App\Http\Controllers\Admin\TanggapanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home route
Route::get('/', [UserController::class, 'index'])->name('home');

// Pelaporan routes
Route::get('/pelaporan', [UserController::class, 'pelaporan'])->name('pelaporan');
Route::post('/pelaporan/kirim', [UserController::class, 'storePelaporan'])->name('pelaporan.store');
Route::get('/laporan/{who?}', [UserController::class, 'laporan'])->name('pelaporan.laporan');
Route::get('/pelaporan-detail/{id_pelaporan}', [UserController::class, 'detailPelaporan'])->name('pelaporan.detail');

// Login route
Route::get('/login', [UserController::class, 'masuk']);

// Admin routes
Route::prefix('admin')->group(function() {
    Route::middleware('isAdmin')->group(function() {
       Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
       Route::resource('/petugas', PetugasController::class);
       Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
       Route::post('/laporan-get', [LaporanController::class, 'laporan'])->name('laporan.get');
       Route::post('/laporan/export', [LaporanController::class, 'export'])->name('laporan.export');
    });

    Route::middleware('isPetugas')->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/logout', [AdminController::class, 'logout'])->name('admin.logout');

        // Pelaporan
        Route::get('pelaporan/{status}', [PelaporanController::class, 'index'])->name('pelaporan.index');
        Route::get('pelaporan/verif/{id_pelaporan}', [PelaporanController::class, 'verif'])->name('pelaporan.verif');
        Route::get('pelaporan/show/{id_pelaporan}', [PelaporanController::class, 'show'])->name('pelaporan.show');
        Route::delete('pelaporan/delete/{id_pelaporan}', [PelaporanController::class, 'destroy'])->name('pelaporan.delete');
        Route::delete('/pelaporan/{id_pelaporan}', [PelaporanController::class, 'destroy'])->name('pelaporan.destroy');

        // Tanggapan
        Route::post('tanggapan', [TanggapanController::class, 'response'])->name('tanggapan');
    });

    Route::middleware(['isGuest'])->group(function () {
        Route::get('/login', [AdminController::class, 'masuk'])->name('admin.masuk');
        Route::post('/login/auth', [AdminController::class, 'login'])->name('admin.login');
        Route::get('/', [AdminController::class, 'formLogin'])->name('admin.masuk');
        Route::post('/login', [AdminController::class, 'login'])->name('admin.login');
    });
});