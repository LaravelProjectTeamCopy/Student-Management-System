<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\AttendanceController;

Route::get('/', [AuthController::class, 'messagelogin']);
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
    Route::get('/welcome', [AuthController::class, 'welcome'])->name('dashboard');

    // Student
    Route::get('/create',    [StudentController::class, 'showcreate']);
    Route::post('/create',   [StudentController::class, 'studentcreate'])->name('students.create');
    Route::get('/import',    [StudentController::class, 'showimport']);
    Route::post('/import',   [StudentController::class, 'import'])->name('students.import');
    Route::get('/index',     [StudentController::class, 'showindex'])->name('students.index');
    Route::get('/students/{id}/show', [StudentController::class, 'show'])->name('students.show');
    Route::get('/export',    [StudentController::class, 'showexport']);
    Route::get('/exportcsv', [StudentController::class, 'export'])->name('students.export');

    // Financial
    Route::get('/financials',           [FinancialController::class, 'financialindex'])->name('financials.index');
    Route::get('/financials/create',    [FinancialController::class, 'financialcreate'])->name('financials.create');
    Route::post('/financials/create',   [FinancialController::class, 'financialstore'])->name('financials.store');
    Route::get('/financials/{id}/show', [FinancialController::class, 'financialshow'])->name('financials.show');
    Route::get('/financials/{id}/edit', [FinancialController::class, 'financialedit'])->name('financials.edit');
    Route::put('/financials/{id}/edit', [FinancialController::class, 'financialupdate'])->name('financials.edit');
    Route::get('/financials/{id}/history', [FinancialController::class, 'finacialhistory'])->name('financials.history');
    Route::get('/financials/import',    [FinancialController::class, 'showfinancialimport']);
    Route::get('/financials/export',    [FinancialController::class, 'showfinancialexport']);
    Route::post('/financials/import',   [FinancialController::class, 'financialimport'])->name('financials.import');
    Route::get('/financials/exportcsv',   [FinancialController::class, 'financialexport'])->name('financials.export');

    // Attendance
    Route::get('/attendances',           [AttendanceController::class, 'attendanceindex'])->name('attendances.index');
    Route::get('/attendances/create',    [AttendanceController::class, 'attendancecreate'])->name('attendances.create');
    Route::post('/attendances/create',   [AttendanceController::class, 'attendancestore'])->name('attendances.store');
    Route::get('/attendances/{id}/show', [AttendanceController::class, 'attendanceshow'])->name('attendances.show');
    Route::get('/attendances/{id}/edit', [AttendanceController::class, 'attendanceedit'])->name('attendances.edit');
    Route::put('/attendances/{id}/edit', [AttendanceController::class, 'attendanceupdate'])->name('attendances.update');
    Route::get('/attendances/{id}/history', [AttendanceController::class, 'attendancehistory'])->name('attendances.history');
    Route::get('/attendances/import',    [AttendanceController::class, 'showattendanceimport'])->name('attendances.import');
    Route::get('/attendances/export',    [AttendanceController::class, 'showattendanceexport']);
    Route::post('/attendances/import',   [AttendanceController::class, 'attendanceimport'])->name('attendances.import');
    Route::get('/attendances/exportcsv',   [AttendanceController::class, 'attendanceexport'])->name('attendances.export');
});