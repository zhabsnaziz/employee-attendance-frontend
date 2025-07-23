<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AttendanceLogController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('departments', DepartmentController::class);
Route::resource('employees', EmployeeController::class);

Route::post('/departments/{id}/delete', [DepartmentController::class, 'destroy'])->name('departments.destroy');
Route::post('/employees/{id}/delete', [EmployeeController::class, 'destroy'])->name('employees.destroy');

Route::get('attendance', [AttendanceController::class, 'create'])->name('attendance.create');
Route::post('attendance/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clockIn');
Route::put('attendance/clock-out', [AttendanceController::class, 'clockOut'])->name('attendance.clockOut');

Route::get('attendance/logs', [AttendanceLogController::class, 'index'])->name('attendance.logs');
