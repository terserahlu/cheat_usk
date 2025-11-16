<?php

use App\Http\Controllers\Auth\authController;
use App\Http\Controllers\Auth\viewController;
use App\Http\Controllers\System\MenuController;
use App\Http\Controllers\System\MejaController;
use App\Http\Controllers\System\Transactions\OrderController;
use App\Http\Controllers\System\Transactions\TransaksiController;
use App\Http\Controllers\System\Transactions\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', [viewController::class, 'loginView'])->name('login');
Route::post('/auth/login',[authController::class, 'login'])->name('auth.login');

Route::middleware('auth')->group(function(){
    Route::post('/auth/logout',[authController::class, 'logout'])->name('auth.logout');
    Route::get('/dashboard', [\App\Http\Controllers\viewController::class, 'dashboard'])->name('dashboard');
    
    // Routes Meja
    Route::prefix('meja')->name('meja.')->group(function(){
        Route::get('/', [MejaController::class, 'index'])->name('index');
        Route::get('/create', [MejaController::class, 'create'])->name('create');
        Route::post('/', [MejaController::class, 'store'])->name('store');
        Route::get('/{id}', [MejaController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [MejaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MejaController::class, 'update'])->name('update');
        Route::delete('/{id}', [MejaController::class, 'destroy'])->name('destroy');
    });
    
    // Routes Menu
    Route::prefix('menu')->name('menu.')->group(function(){
        Route::get('/', [MenuController::class, 'index'])->name('index');
        Route::get('/create', [MenuController::class, 'create'])->name('create');
        Route::post('/', [MenuController::class, 'store'])->name('store');
        Route::get('/{id}', [MenuController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [MenuController::class, 'edit'])->name('edit');
        Route::put('/{id}', [MenuController::class, 'update'])->name('update');
        Route::delete('/{id}', [MenuController::class, 'destroy'])->name('destroy');
    });
    
    // Routes Orderan
    Route::prefix('orderan')->name('orderan.')->group(function(){
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create', function(){
            return view('orderan.create');
        })->name('create');
        Route::post('/', [OrderController::class, 'order'])->name('store');
    });
    
    // Routes Transaksi
    Route::prefix('transaksi')->name('transaksi.')->group(function(){
        Route::get('/', [TransaksiController::class, 'index'])->name('index');
        Route::get('/create', function(){
            return view('transaksi.create');
        })->name('create');
        Route::post('/', [TransaksiController::class, 'transaksi'])->name('store');
    });
    
    // Routes Laporan
    Route::prefix('laporan')->name('laporan.')->group(function(){
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/{idPelanggan}', [LaporanController::class, 'show'])->name('show');
        Route::get('/download/pdf', [LaporanController::class, 'downloadPDF'])->name('download.pdf');
        Route::get('/download/pdf/{idPelanggan}', [LaporanController::class, 'downloadPDFSingle'])->name('download.pdf.single');
    });
});
