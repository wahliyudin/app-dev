<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::post('tasks/{id}/update', [TaskController::class, 'update'])->name('tasks.update');
    Route::post('tasks/store', [TaskController::class, 'store'])->name('tasks.store');
    Route::delete('tasks/{id}/destroy', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('tasks/{key}/features', [TaskController::class, 'features'])->name('tasks.features');
    Route::post('tasks/{key}/developers', [TaskController::class, 'developers'])->name('tasks.developers');
});
