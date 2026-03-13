<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\AttendanceController;

Route::get('/', [AuthController::class, 'showlogin']);
Route::get('/login', [AuthController::class, 'showlogin'])->name('login');
Route::get('/register', [AuthController::class, 'showregister']);
Route::get('/forgot', [AuthController::class, 'showforgot']);
Route::get('/success', [AuthController::class, 'showsuccess']);
Route::get('/verify', [AuthController::class, 'showverify']);
Route::get('/otpsuccess', [AuthController::class, 'showotpsuccess']);
Route::get('/select', [AuthController::class, 'showselect']);
Route::get('/reset', [AuthController::class, 'showreset']);
Route::post('/register', [AuthController::class, 'register'])->name('handleRegister');
Route::post('/login', [AuthController::class, 'login'])->name('handleLogin');
Route::post('/logout', [AuthController::class, 'logout'])->name('handleLogout');
Route::post('/forgot', [AuthController::class, 'sendOtp'])->name('sendOtp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verifyOtp');
Route::post('/reset', [AuthController::class, 'resetpassword'])->name('handleResetPassword');

Route::middleware('auth')->group(function(){
    Route::get('/welcome', [AuthController::class, 'welcome']);

    // Student
    Route::get('/import',    [StudentController::class, 'showimport']);
    Route::post('/import',   [StudentController::class, 'import'])->name('students.import');
    Route::get('/index',     [StudentController::class, 'showindex'])->name('students.index');
    Route::get('/export',    [StudentController::class, 'showexport']);
    Route::get('/exportcsv', [StudentController::class, 'export'])->name('students.export');

    // Financial
    Route::get('/financials',           [FinancialController::class, 'financialindex']);
    Route::get('/financials/{id}/show', [FinancialController::class, 'financialshow'])->name('financials.show');
    Route::get('/financials/{id}/edit', [FinancialController::class, 'financialedit']);
    Route::put('/financials/{id}/edit', [FinancialController::class, 'financialupdate'])->name('financials.edit');

    // Attendance
    Route::get('/attendances',           [AttendanceController::class, 'attendanceindex']);
    Route::get('/attendances/{id}/show', [AttendanceController::class, 'attendanceshow'])->name('attendance.show');
    Route::get('/attendances/{id}/edit', [AttendanceController::class, 'attendanceedit'])->name('attendance.edit');
    Route::put('/attendances/{id}/edit', [AttendanceController::class, 'attendanceupdate'])->name('attendance.update');
});