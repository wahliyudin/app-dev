<?php

use App\Http\Controllers\Applications\TaskController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('applications/{id}/tasks', [TaskController::class, 'index'])->name('applications.tasks.index');
    Route::get('applications/tasks/{key}/edit', [TaskController::class, 'edit'])->name('applications.tasks.edit');
    Route::post('applications/tasks/{key}/update', [TaskController::class, 'update'])->name('applications.tasks.update');
    Route::post('applications/tasks/store', [TaskController::class, 'store'])->name('applications.tasks.store');
    Route::delete('applications/tasks/{key}/destroy', [TaskController::class, 'destroy'])->name('applications.tasks.destroy');
});
