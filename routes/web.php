<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;

// 
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login'); // register ki jagah login
});

// ─── Auth Protected Routes ───────────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [TaskController::class, 'dashboard'])
         ->name('dashboard');

    // Tasks CRUD 
    Route::resource('tasks', TaskController::class)->except(['show']);
    // Products CRUD
    Route::resource('products', ProductController::class)->except(['show']);
    // Categories CRUD
    Route::resource('categories', CategoryController::class)->except(['show']);
    

    // AJAX status update — alag route 
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])
         ->name('tasks.updateStatus');

     // new route for status update for products
     Route::patch('/products/{product}/status', [ProductController::class, 'updateStatus'])
         ->name('products.updateStatus');


         // Activity logs page
     Route::get('/activity-logs', [ActivityLogController::class, 'index'])
     ->name('activity-logs.index');
         

    // // Activity logs page
    // Route::get('/activity-logs', [TaskController::class, 'activityLogs'])
    //      ->name('tasks.activityLogs');

    // ─── Breeze Profile Routes ───────────────────────────────────
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';