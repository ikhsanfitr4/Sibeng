<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Owner\DashboardController as OwnerDashboardController;
use App\Http\Controllers\Owner\MekanikController;
use App\Http\Controllers\Owner\PelangganController;
use App\Http\Controllers\Owner\ServisController;
use App\Http\Controllers\Owner\SparePartController;
use App\Http\Controllers\Owner\TransaksiController;
use App\Http\Controllers\Owner\LaporanController;
use App\Http\Controllers\Owner\PengaturanController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => redirect()->route('login'));
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Di luar semua group, setelah route logout
Route::get('/api/kendaraan/{pelanggan}', function (\App\Models\Pelanggan $pelanggan) {
    return response()->json($pelanggan->kendaraans);
});

/*
|--------------------------------------------------------------------------
| Owner Routes
|--------------------------------------------------------------------------
*/
Route::prefix('owner')
    ->name('owner.')
    ->middleware(['auth', 'owner'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');

        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

        // Mekanik
        Route::resource('/mekanik', MekanikController::class);

        // Pelanggan
        Route::resource('/pelanggan', PelangganController::class);

        // Kendaraan (nested under pelanggan)
        Route::prefix('/pelanggan/{pelanggan}/kendaraan')
            ->name('kendaraan.')
            ->group(function () {
            Route::get('/create', [\App\Http\Controllers\Owner\KendaraanController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Owner\KendaraanController::class, 'store'])->name('store');
            Route::get('/{kendaraan}/edit', [\App\Http\Controllers\Owner\KendaraanController::class, 'edit'])->name('edit');
            Route::put('/{kendaraan}', [\App\Http\Controllers\Owner\KendaraanController::class, 'update'])->name('update');
            Route::delete('/{kendaraan}', [\App\Http\Controllers\Owner\KendaraanController::class, 'destroy'])->name('destroy');
        });

        // Servis
        Route::resource('/servis', ServisController::class)->parameters([
            'servis' => 'servis'
        ]);


        // Spare Part
        Route::resource('/spare-part', SparePartController::class);

        // Transaksi
        Route::resource('/transaksi', TransaksiController::class);

        Route::resource('/user', \App\Http\Controllers\Owner\UserController::class)->except(['show']);

        // Pengaturan
        Route::get('/pengaturan', [PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::post('/pengaturan', [PengaturanController::class, 'update'])->name('pengaturan.update');

        Route::get('/transaksi/{transaksi}/print', [\App\Http\Controllers\Owner\TransaksiController::class, 'print'])->name('transaksi.print');

        Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');


        // Kendaraan by pelanggan (untuk form servis)
        Route::get('/api/kendaraan/{pelanggan}', function (\App\Models\Pelanggan $pelanggan) {
            return response()->json($pelanggan->kendaraans);
        })->name('api.kendaraan');

        // Audit Log
        Route::get('/audit-log', [\App\Http\Controllers\Owner\AuditLogController::class, 'index'])->name('audit-log.index');
        Route::delete('/audit-log', [\App\Http\Controllers\Owner\AuditLogController::class, 'destroy'])->name('audit-log.destroy');
        Route::get('/audit-log/export', [\App\Http\Controllers\Owner\AuditLogController::class, 'export'])
    	->name('audit-log.export');

        // Backup
        Route::get('/backup', [\App\Http\Controllers\Owner\BackupController::class, 'index'])->name('backup.index');
        Route::post('/backup', [\App\Http\Controllers\Owner\BackupController::class, 'create'])->name('backup.create');
        Route::get('/backup/download', [\App\Http\Controllers\Owner\BackupController::class, 'download'])->name('backup.download');
        Route::delete('/backup', [\App\Http\Controllers\Owner\BackupController::class, 'destroy'])->name('backup.destroy');


    });

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin_role'])
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('/servis', \App\Http\Controllers\Admin\ServisController::class)->parameters([
            'servis' => 'servis'
        ]);
        Route::resource('/spare-part', \App\Http\Controllers\Admin\SparePartController::class);
        Route::resource('/transaksi', \App\Http\Controllers\Admin\TransaksiController::class);
        Route::resource('/pelanggan', \App\Http\Controllers\Admin\PelangganController::class);
        Route::get('/mekanik', [\App\Http\Controllers\Admin\MekanikController::class, 'index'])->name('mekanik.index');

        // Profile Admin
        Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/password', [\App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.password');

        Route::get('/transaksi/{transaksi}/print', [\App\Http\Controllers\Admin\TransaksiController::class, 'print'])->name('transaksi.print');

        // Kendaraan nested
        Route::prefix('/pelanggan/{pelanggan}/kendaraan')
            ->name('kendaraan.')
            ->group(function () {
            Route::get('/create', [\App\Http\Controllers\Admin\KendaraanController::class, 'create'])->name('create');
            Route::post('/', [\App\Http\Controllers\Admin\KendaraanController::class, 'store'])->name('store');
            Route::get('/{kendaraan}/edit', [\App\Http\Controllers\Admin\KendaraanController::class, 'edit'])->name('edit');
            Route::put('/{kendaraan}', [\App\Http\Controllers\Admin\KendaraanController::class, 'update'])->name('update');
            Route::delete('/{kendaraan}', [\App\Http\Controllers\Admin\KendaraanController::class, 'destroy'])->name('destroy');
        });
    });

