<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::middleware(['auth'])->group(function () {

    /*========================
    ADMIN
    ==========================*/
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::resource('/users/management', UserController::class)->names('user.management');
        Route::post('users/{user}/reset-password', [UserController::class, 'resetPasswordAdmin'])->name('user.management.reset');
    });

    /*========================
    PENGAJAR
    ==========================*/
    Route::middleware(['role:pengajar'])->prefix('pengajar')->group(function () {
        Route::get('/dashboard', function () {
            return view('pengajar.dashboard');
        })->name('pengajar.dashboard');
    });

    /*========================
    STAFF
    ==========================*/
    Route::middleware(['role:staff'])->prefix('staff')->group(function () {
        Route::get('/dashboard', function () {
            return view('staff.dashboard');
        })->name('staff.dashboard');
    });

    /*========================
    SISWA
    ==========================*/
    Route::middleware(['role:siswa'])->prefix('siswa')->group(function () {
        Route::get('/dashboard', function () {
            return view('siswa.dashboard');
        })->name('siswa.dashboard');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/reset/password', [AuthController::class, 'showResetPassword'])->name('view.reset');
    Route::post('/reset/password', [AuthController::class, 'resetPassword'])->name('post.reset');
});
