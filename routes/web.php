<?php

use App\Http\Controllers\BiodataController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PengalamanController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Rute Publik (Bisa diakses tanpa login)
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('question/store', [QuestionController::class, 'store'])
    ->name('question.store');

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');

// Rute Privat
Route::middleware(['checkislogin'])->group(function () {
    
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('biodata', BiodataController::class)->parameters([
        'biodata' => 'biodata',
    ]);
    Route::post('biodata/{biodata}/foto', [BiodataController::class, 'updateFoto'])->name('biodata.foto');

    Route::post('pengalaman', [PengalamanController::class, 'store'])->name('pengalaman.store');
    Route::put('pengalaman/{pengalaman}', [PengalamanController::class, 'update'])->name('pengalaman.update');
    Route::delete('pengalaman/{pengalaman}', [PengalamanController::class, 'destroy'])->name('pengalaman.destroy');

    Route::post('dokumen', [DokumenController::class, 'store'])->name('dokumen.store');
    Route::delete('dokumen/{dokuman}', [DokumenController::class, 'destroy'])->name('dokumen.destroy');
    Route::put('dokumen/{dokuman}', [DokumenController::class, 'update'])->name('dokumen.update');

});

// Rute Role
Route::middleware(['auth'])->group(function () {
    
    Route::middleware(['checkrole:Super Admin'])->group(function () {
        Route::resource('user', UserController::class);
    });

    Route::middleware(['checkrole:Super Admin,mitra'])->group(function () {
        Route::resource('pelanggan', PelangganController::class);
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

});