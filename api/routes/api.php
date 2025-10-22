<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentication routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

// User management routes
Route::put('/user/update', [UserController::class, 'update'])->middleware(['auth:sanctum']);
Route::delete('/user/delete', [UserController::class, 'delete'])->middleware(['auth:sanctum']);

// Admin routes
Route::get('admin/users', [AdminController::class, 'getAllUsers'])
        ->middleware(['auth:sanctum', 'is-admin']);

// Machine routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/machines', [\App\Http\Controllers\MachineController::class, 'index']);
    Route::get('/machines/{machine}', [\App\Http\Controllers\MachineController::class, 'show']);
    Route::post('/machines/{machine}/action', [\App\Http\Controllers\MachineController::class, 'action']);
});