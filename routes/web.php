<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware(['auth'])->group(function () {

    Route::middleware(['role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            // ======================
            // Dashboard
            // ======================
            Route::get('/dashboard', function () {
                return view('admin.dashboard');
            })->name('dashboard');


            // ======================
            // USER MANAGEMENT
            // ======================
            Route::get('/pengguna', function () {
                return view('admin.user_managements.users.index');
            })->name('users.index');
            Route::get('/pengajar', function () {
                return view('admin.user_managements.teachers.index');
            })->name('teachers.index');
            Route::get('/siswa', function () {
                return view('admin.user_managements.students.index');
            })->name('students.index');


            // ======================
            // ACADEMIC
            // ======================
            Route::get('/kelas', function () {
                return view('admin.academic_managements.classes.index');
            })->name('classes.index');
            Route::get('/pendaftaran', function () {
                return view('admin.academic_managements.enrollments.index');
            })->name('enrollments.index');
            Route::get('/jadwal', function () {
                return view('admin.academic_managements.schedules.index');
            })->name('schedules.index');
            Route::get('/presensi', function () {
                return view('admin.academic_managements.attendances.index');
            })->name('attendances.index');
            Route::get('/presensi-siswa', function () {
                return view('admin.academic_managements.student_attendances.index');
            })->name('student-attendances.index');


            // ======================
            // CONTRACT & PAYROLL
            // ======================
            Route::get('/spk', function () {
                return view('admin.contract_and_payrolls.spks.index');
            })->name('spk.index');
            Route::get('/periode-gaji', function () {
                return view('admin.contract_and_payrolls.payroll_periods.index');
            })->name('payroll-periods.index');
            Route::get('/gaji', function () {
                return view('admin.contract_and_payrolls.payrolls.index');
            })->name('payroll.index');
            Route::get('/detail-gaji', function () {
                return view('admin.contract_and_payrolls.payroll_details.index');
            })->name('payroll-details.index');


            // ======================
            // REPORTS
            // ======================
            Route::get('/laporan-kehadiran', function () {
                return view('admin.reports.attendances_reports.index');
            })->name('reports.attendance');
            Route::get('/laporan-gaji', function () {
                return view('admin.reports.payroll_reports.index');
            })->name('reports.payroll');
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
