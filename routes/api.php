<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TaskApiController;
use Illuminate\Support\Facades\Route;

// Public route — koi token nahi chahiye, sirf email/password
Route::post('/login', [AuthController::class, 'login']);

// Protected routes — Sanctum token chahiye
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // Permission checks wahi jo web mein hain (Spatie)
    Route::get('/tasks',           [TaskApiController::class, 'index'])->middleware('can:view-task');
    Route::get('/tasks/{task}',    [TaskApiController::class, 'show'])->middleware('can:view-task');
    Route::post('/tasks',          [TaskApiController::class, 'store'])->middleware('can:create-task');
    Route::put('/tasks/{task}',    [TaskApiController::class, 'update'])->middleware('can:edit-task');
    Route::delete('/tasks/{task}', [TaskApiController::class, 'destroy'])->middleware('can:delete-task');
});