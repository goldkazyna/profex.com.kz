<?php

use App\Http\Controllers\Api\AppVersionController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\IncomeController;
use App\Http\Controllers\Api\OwnerPayrollController;
use Illuminate\Support\Facades\Route;

// Public — version check (no auth)
Route::get('/app-version', [AppVersionController::class, 'show']);

// Auth
Route::post('/auth/social', [AuthController::class, 'socialLogin']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // User
    Route::get('/me', [AuthController::class, 'me']);
    Route::put('/me/settings', [AuthController::class, 'updateSettings']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::delete('/me', [AuthController::class, 'deleteAccount']);

    // Owner payroll
    Route::get('/owner-payroll', [OwnerPayrollController::class, 'show']);
    Route::put('/owner-payroll', [OwnerPayrollController::class, 'update']);

    // Employee lifecycle
    Route::patch('/employees/{employee}/terminate', [EmployeeController::class, 'terminate']);
    Route::patch('/employees/{employee}/restore', [EmployeeController::class, 'restore']);

    // CRUD
    Route::apiResource('incomes', IncomeController::class);
    Route::apiResource('expenses', ExpenseController::class);
    Route::apiResource('employees', EmployeeController::class);
    Route::apiResource('categories', CategoryController::class)->only(['index', 'store', 'destroy']);
});
