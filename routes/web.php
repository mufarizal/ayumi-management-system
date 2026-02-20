<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware(['auth'])->group(function () {

    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });
    Route::middleware(['role:keuangan'])->prefix('keuangan')->group(function () {
        Route::get('/dashboard', function () {
            return view('keuangan.dashboard');
        })->name('keuangan.dashboard');
    });
    Route::middleware(['role:pengajar'])->prefix('pengajar')->group(function () {
        Route::get('/dashboard', function () {
            return view('pengajar.dashboard');
        })->name('pengajar.dashboard');
    });
});
