<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\DepartmentController;

Route::apiResource('employees', EmployeeController::class)->names('api.employees');
Route::apiResource('departments', DepartmentController::class)->names('api.departments');
