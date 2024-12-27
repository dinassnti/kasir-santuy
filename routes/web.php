<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('kategori', KategoriController::class);
Route::resource('produk', ProdukController::class);
Route::get('/stok', [StokController::class, 'index'])->name('stok.index');
Route::post('/stok/{id}/update', [StokController::class, 'update'])->name('stok.update');
Route::resource('diskon', DiskonController::class);
Route::resource('staff', StaffController::class);
//Transaksi
Route::resource('transaksi', TransaksiController::class);
Route::get('transaksi/struk', [TransaksiController::class, 'struk'])->name('transaksi.struk');
Route::get('/laporan-transaksi', [TransaksiController::class, 'laporanTransaksi'])->name('laporan-transaksi.index');
Route::get('/laporan-transaksi/{id}', [TransaksiController::class, 'detailTransaksi'])->name('laporan-transaksi.detail');
//Toko
Route::middleware('auth')->group(function () {
    Route::get('/toko/edit', function () {
        return redirect()->route('toko.show');
    })->name('toko.edit');
    Route::get('/toko', [TokoController::class, 'show'])->name('toko.show');
    Route::post('/toko/store', [TokoController::class, 'store'])->name('toko.store');
    Route::post('/toko/update', [TokoController::class, 'update'])->name('toko.update');
});

require __DIR__.'/auth.php';
