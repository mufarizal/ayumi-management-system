<?php

use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\PengajarController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\StaffController;
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

        // Dashboard
        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

        // ======================
        // USER MANAGEMENT
        // ======================
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('all');
            Route::get('/admin', [UserController::class, 'index'])->defaults('role', 'admin')->name('admin');
            Route::get('/pengajar', [UserController::class, 'index'])->defaults('role', 'pengajar')->name('pengajar');
            Route::get('/staff', [UserController::class, 'index'])->defaults('role', 'staff')->name('staff');
            Route::get('/siswa', [UserController::class, 'index'])->defaults('role', 'siswa')->name('siswa');
            Route::get('/search', [UserController::class, 'search'])->name('search');
            Route::get('/create/{role}', [UserController::class, 'create'])->name('create');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
            Route::put('/update/{user}', [UserController::class, 'update'])->name('update');
            Route::delete('/delete/{user}', [UserController::class, 'destroy'])->name('delete');
            Route::post('/{user}/reset-password', [UserController::class, 'resetPasswordAdmin'])->name('reset');
        });


        // ======================
        // STAFF & PENGAJAR MANAGEMENT
        // ======================
        Route::resource('siswa', SiswaController::class);
        Route::resource('staff', StaffController::class);
        Route::resource('pengajar', PengajarController::class);

        // ======================
        // ACADEMIC
        // ======================
        Route::resource('program', ProgramController::class);
        Route::resource('kelas', KelasController::class);
        Route::get('/pendaftaran', fn() => view('admin.academic_managements.enrollments.index'))->name('enrollments.index');
        Route::get('/jadwal', fn() => view('admin.academic_managements.schedules.index'))->name('schedules.index');
        Route::get('/presensi', fn() => view('admin.academic_managements.attendances.index'))->name('attendances.index');
        Route::get('/presensi-siswa', fn() => view('admin.academic_managements.student_attendances.index'))->name('student-attendances.index');

        // ======================
        // CONTRACT & PAYROLL
        // ======================
        Route::get('/spk', fn() => view('admin.contract_and_payrolls.spks.index'))->name('spk.index');
        Route::get('/periode-gaji', fn() => view('admin.contract_and_payrolls.payroll_periods.index'))->name('payroll-periods.index');
        Route::get('/gaji', fn() => view('admin.contract_and_payrolls.payrolls.index'))->name('payroll.index');
        Route::get('/detail-gaji', fn() => view('admin.contract_and_payrolls.payroll_details.index'))->name('payroll-details.index');

        // ======================
        // REPORTS
        // ======================
        Route::get('/laporan-kehadiran', fn() => view('admin.reports.attendances_reports.index'))->name('reports.attendance');
        Route::get('/laporan-gaji', fn() => view('admin.reports.payroll_reports.index'))->name('reports.payroll');
    });

    /*========================
     PENGAJAR
    ==========================*/
    Route::middleware(['role:pengajar'])->prefix('pengajar')->name('pengajar.')->group(function () {
        Route::get('/dashboard', fn() => view('pengajar.dashboard'))->name('dashboard');
    });

    /*========================
     STAFF
    ==========================*/
    Route::middleware(['role:staff'])->prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', fn() => view('staff.dashboard'))->name('dashboard');
    });

    /*========================
     SISWA
    ==========================*/
    Route::middleware(['role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/dashboard', fn() => view('siswa.dashboard'))->name('dashboard');
    });

    // Auth
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/reset/password', [AuthController::class, 'showResetPassword'])->name('view.reset');
    Route::post('/reset/password', [AuthController::class, 'resetPassword'])->name('post.reset');
    Route::post('/switch-role', [AuthController::class, 'switchRole'])->name('switch.role');
});
