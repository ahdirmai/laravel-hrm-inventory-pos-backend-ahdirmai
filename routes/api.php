<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AuthController as ApiAuthController;
use App\Http\Controllers\Api\BasicSalaryController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\DesignationController;
use App\Http\Controllers\Api\LeaveController;
use App\Http\Controllers\Api\LeaveTypeController;
use App\Http\Controllers\Api\PayrollController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\ShiftController;
use App\Models\Designation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/logout', [ApiAuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// roles
Route::middleware('auth:sanctum')->apiResource('/roles', RoleController::class);

// departments
Route::middleware('auth:sanctum')->apiResource('/departments', DepartmentController::class);

// designations
Route::middleware('auth:sanctum')->apiResource('/designations', DesignationController::class);

// shifts
Route::middleware('auth:sanctum')->apiResource('/shifts', ShiftController::class);

// basic salary
Route::middleware('auth:sanctum')->apiResource('/basic-salary', BasicSalaryController::class);

// leave types
Route::middleware('auth:sanctum')->apiResource('/leave-types', LeaveTypeController::class);


// leaves
Route::middleware('auth:sanctum')->apiResource('/leaves', LeaveController::class);


// attendances
Route::middleware('auth:sanctum')->apiResource('/attendances', AttendanceController::class);

// payrolls
Route::middleware('auth:sanctum')->apiResource('/payrolls', PayrollController::class);
