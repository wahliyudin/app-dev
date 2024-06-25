<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::post('tasks/datatable', [TaskController::class, 'datatable'])->name('tasks.datatable');
    Route::get('tasks/{key}/show', [TaskController::class, 'show'])->name('tasks.show');
    Route::get('tasks/{key}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
    Route::post('tasks/store', [TaskController::class, 'store'])->name('tasks.store');
    Route::delete('tasks/{key}/destroy', [TaskController::class, 'destroy'])->name('tasks.destroy');
    Route::post('tasks/{key}/update', [TaskController::class, 'update'])->name('tasks.update');
});
