<?php

use App\Http\Controllers\Applications\TaskController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth'])->group(function () {
    Route::get('applications/{id}/tasks', [TaskController::class, 'index'])->name('applications.tasks.index');
});
