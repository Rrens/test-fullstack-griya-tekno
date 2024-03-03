<?php

use App\Http\Controllers\Admin\PaketController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Pegawai\TransactionController as PegawaiTransactionController;
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

// Route::redirect('/', 'sales');
Route::group([
    'prefix' => 'auth',
], function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('post-login', [AuthController::class, 'post_login'])->name('post-login');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::group([
    'middleware' => ['auth']
], function () {
    Route::group([
        'prefix' => 'sales',
        'middleware' => ['role:admin']
    ], function () {
        Route::get('', [SalesController::class, 'index'])->name('admin.sales.index');
        Route::post('',  [SalesController::class, 'store'])->name('admin.sales.store');
        Route::post('update',  [SalesController::class, 'update'])->name('admin.sales.update');
        Route::post('delete',  [SalesController::class, 'delete'])->name('admin.sales.delete');
    });

    Route::group([
        'prefix' =>   'paket',
        'middleware' => ['role:admin']
    ], function () {
        Route::get('', [PaketController::class, 'index'])->name('admin.paket.index');
        Route::post('', [PaketController::class, 'store'])->name('admin.paket.store');
        Route::post('update', [PaketController::class, 'update'])->name('admin.paket.update');
        Route::post('delete', [PaketController::class, 'delete'])->name('admin.paket.delete');
    });

    Route::group([
        'prefix' => 'transaction',
        'middleware' => ['role:admin']
    ], function () {
        Route::get('', [TransactionController::class, 'index'])->name('admin.transaction.index');
        Route::post('verification', [TransactionController::class, 'verification'])->name('admin.transaction.verification');
    });

    Route::group([
        'prefix' => 'transaction-pegawai',
        'middleware' => ['role:pegawai']
    ], function () {
        Route::get('', [PegawaiTransactionController::class, 'index'])->name('pegawai.transaction.index');
        Route::post('', [PegawaiTransactionController::class, 'store'])->name('pegawai.transaction.store');
        Route::post('update', [PegawaiTransactionController::class, 'update'])->name('pegawai.transaction.update');
        Route::post('delete', [PegawaiTransactionController::class, 'delete'])->name('pegawai.transaction.delete');
        Route::post('change-ktp', [PegawaiTransactionController::class, 'update_ktp_customer'])->name('pegawai.transaction.update_ktp_customer');
        Route::post('change-house-photo', [PegawaiTransactionController::class, 'update_house_customer'])->name('pegawai.transaction.update_house_customer');
        Route::post('delete-house-photo', [PegawaiTransactionController::class, 'delete_house_customer'])->name('pegawai.transaction.delete_house_customer');
    });
});
