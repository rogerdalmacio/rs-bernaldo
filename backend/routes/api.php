<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeProjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/departments', [DepartmentController::class, 'index']);
Route::get('/employees', [EmployeeController::class, 'index']);
Route::get('/employees/projects', [EmployeeProjectController::class, 'index']);
Route::post('/employees/{employee}/projects', [EmployeeProjectController::class, 'store']);
