<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

// Welcome page
Route::get('/', fn() => view('welcome'));

// ─── Auth Protected Routes ───────────────────────────────────────
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [TaskController::class, 'dashboard'])
         ->name('dashboard');

    // Tasks CRUD (show route nahi chahiye)
    Route::resource('tasks', TaskController::class)->except(['show']);

    // AJAX status update — alag route (resource ke bahar)
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])
         ->name('tasks.updateStatus');

    // // Activity logs page
    // Route::get('/activity-logs', [TaskController::class, 'activityLogs'])
    //      ->name('tasks.activityLogs');

    // ─── Breeze Profile Routes ───────────────────────────────────
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';