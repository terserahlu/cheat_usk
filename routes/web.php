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
    
    Route::middleware('role:admin')->group(function(){
        Route::resource('meja', MejaController::class)->parameters([
            'meja' => 'id'
        ]);
    });
    
    Route::middleware('role:admin,waiter')->prefix('menu')->group(function(){
        Route::resource('menu', MenuController::class)->parameters([
            'menu' => 'id'
        ]);
    });
    
    Route::middleware('role:waiter')->prefix('orderan')->name('orderan.')->group(function(){
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create', function(){
            return view('orderan.create');
        })->name('create');
        Route::post('/', [OrderController::class, 'order'])->name('store');
    });
    
    Route::middleware('role:kasir')->prefix('transaksi')->name('transaksi.')->group(function(){
        Route::get('/', [TransaksiController::class, 'index'])->name('index');
        Route::get('/create', function(){
            return view('transaksi.create');
        })->name('create');
        Route::post('/', [TransaksiController::class, 'transaksi'])->name('store');
    });
    
    Route::middleware('role:waiter,kasir,owner')->prefix('laporan')->name('laporan.')->group(function(){
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/{idPelanggan}', [LaporanController::class, 'show'])->name('show');
        Route::get('/download/pdf', [LaporanController::class, 'downloadPDF'])->name('download.pdf');
        Route::get('/download/pdf/{idPelanggan}', [LaporanController::class, 'downloadPDFSingle'])->name('download.pdf.single');
    });
});
