<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('admin/users', [AdminController::class, 'getAllUsers'])
        ->middleware(['auth:sanctum', 'is-admin']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::put('/user/update', [UserController::class, 'update'])->middleware(['auth:sanctum']);
Route::delete('/user/delete', [UserController::class, 'delete'])->middleware(['auth:sanctum']);