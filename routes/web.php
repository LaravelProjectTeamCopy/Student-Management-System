<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AcademicRecordsController;

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

Route::middleware('auth')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'dashboardindex'])->name('dashboard.index');
  
    // Students
    Route::get('/student', [StudentController::class, 'studentindex'])->name('students.index');
    Route::get('/student/{id}/show', [StudentController::class, 'studentshow'])->name('students.show');
    Route::get('/student/create',    [StudentController::class, 'showstudentcreate']);
    Route::post('/student/create',   [StudentController::class, 'studentcreate'])->name('students.create');
    Route::get('/student/import',    [StudentController::class, 'showimport']);
    Route::post('/student/import',   [StudentController::class, 'import'])->name('students.import');
    Route::get('/student/index',     [StudentController::class, 'showindex'])->name('students.index');
    Route::get('/student/export',    [StudentController::class, 'showexport']);
    Route::get('/student/exportcsv', [StudentController::class, 'export'])->name('students.export');

    // Financials
    Route::get('/financials',                    [FinancialController::class, 'financialindex'])->name('financials.index');
    Route::get('/financials/studenthistory',     [FinancialController::class, 'financialallhistory'])->name('financials.studenthistory');
    Route::get('/financials/deadline',           [FinancialController::class, 'financialdeadline'])->name('financials.deadline');
    Route::get('/financials/import',             [FinancialController::class, 'showfinancialimport']);
    Route::get('/financials/export',             [FinancialController::class, 'showfinancialexport']);
    Route::get('/financials/exportcsv',          [FinancialController::class, 'financialexport'])->name('financials.export');
    Route::get('/financials/{id}/show',          [FinancialController::class, 'financialshow'])->name('financials.show');
    Route::get('/financials/{id}/history',       [FinancialController::class, 'financialhistory'])->name('financials.history');
    Route::get('/financials/{id}/edit',          [FinancialController::class, 'financialedit'])->name('financials.edit');
    Route::put('/financials/{id}/edit',          [FinancialController::class, 'financialupdate']);
    Route::post('/financials/import',            [FinancialController::class, 'financialimport'])->name('financials.import');
    Route::post('/financials/deadline',          [FinancialController::class, 'financialsetdeadline'])->name('financials.overdue');
    Route::post('/financials/cleardeadline',     [FinancialController::class, 'financialcleardeadline'])->name('financials.cleardeadline');

    // Attendances
    Route::get('/attendances',                       [AttendanceController::class, 'attendanceindex'])->name('attendances.index');
    Route::get('/attendances/import',                [AttendanceController::class, 'showattendanceimport'])->name('attendances.import');
    Route::get('/attendances/export',                [AttendanceController::class, 'showattendanceexport']);
    Route::get('/attendances/exportcsv',             [AttendanceController::class, 'attendanceexport'])->name('attendances.export');
    Route::get('/attendances/duration',              [AttendanceController::class, 'attendanceduration'])->name('attendances.duration');
    Route::get('/attendances/studenthistory',        [AttendanceController::class, 'attendanceallhistory'])->name('attendances.studenthistory');
    Route::get('/attendances/{id}/show',             [AttendanceController::class, 'attendanceshow'])->name('attendances.show');
    Route::get('/attendances/{id}/edit',             [AttendanceController::class, 'attendanceedit'])->name('attendances.edit');
    Route::get('/attendances/{id}/history',          [AttendanceController::class, 'attendancehistory'])->name('attendances.history');
    Route::get('/attendances/{id}/result',           [AttendanceController::class, 'attendanceresult'])->name('attendances.result');
    Route::put('/attendances/{id}/edit',             [AttendanceController::class, 'attendanceupdate'])->name('attendances.update');
    Route::post('/attendances/import',               [AttendanceController::class, 'attendanceimport'])->name('attendances.storeimport');
    Route::post('/attendances/duration',             [AttendanceController::class, 'attendancesetduration'])->name('attendances.setduration');
    Route::post('/attendances/cancelduration',       [AttendanceController::class, 'attendancecleardeadline'])->name('attendances.cleardeadline');
    Route::delete('/attendances/studenthistory/delete', [AttendanceController::class, 'attendanceallhistorydelete'])->name('attendances.deleteallstudenthistory');

    // Academic Records
    Route::get('/academics',              [AcademicRecordsController::class, 'academicrecordsindex'])->name('academicrecords.index');
    Route::get('/academics/import',       [AcademicRecordsController::class, 'showacademicrecordsimport'])->name('academicrecords.import');
    Route::get('/academics/{id}/show',    [AcademicRecordsController::class, 'academicrecordsshow'])->name('academicrecords.show');
    Route::post('/academics/import',      [AcademicRecordsController::class, 'academicrecordimport'])->name('academicrecords.storeimport');
    Route::get('/academics/subject',      [AcademicRecordsController::class, 'showacademicrecordssubject'])->name('academicrecords.subject');
    Route::post('/academics/subject',     [AcademicRecordsController::class, 'academicrecordssubject'])->name('academicrecords.subjectstore');
});